<?php

namespace App\Http\Controllers;

use App\Models\Centro_custo;
use App\Models\Contrato;
use App\Models\Fonecedor_cliente;
use App\Models\Produto;
use App\Models\Agenda;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
        public function contratos(){
            $user_id = auth()->user()->id;
            if($user_id){
                $contratos = DB::table('contratos')
                ->select(['produtos.nome as produto','contratos.id_centro_custo','contratos.id_produto','fornecedor_clientes.nome as cliente','contratos.id_for_cli','contratos.data_pagamento','contratos.numero_contrato', 'contratos.data_inicio', 'contratos.data_fim', 'contratos.id_contrato', 'contratos.numero_contrato', 'contratos.data_reajuste', 'contratos.status', 'contratos.descricao', 'contratos.valor'])
               ->leftJoin('produtos', 'produtos.id_produto', '=', 'contratos.id_produto')
               ->join('fornecedor_clientes', 'fornecedor_clientes.id_for_cli', '=', 'contratos.id_for_cli')
               ->where('contratos.id_usuario', $user_id)
               ->orderBy('contratos.id_contrato', 'DESC')
               ->get();
               $for_cli = Fonecedor_cliente::select('nome','id_for_cli')->where('id_usuario', $user_id)->orderBy('nome')->get();
               $produto = Produto::select('nome','id_produto')->where('id_usuario', $user_id)->orderBy('nome')->get();
               $centro_custo = Centro_custo::select('nome','id_centro_custo')->where('id_usuario', $user_id)->orderBy('nome')->get();

                return view ('contrato/contrato',['contratos' => $contratos,'for_cli' => $for_cli,'produtos' => $produto,'centro_custo' => $centro_custo]);

            }else{
                return redirect('/');
            }
        }

        public function busca_contrato(Request $request){
            $numero = $request->numero;
            $user_id = auth()->user()->id;

            $contrato = Contrato::where('id_usuario', $user_id)
                                ->where('numero_contrato', $numero)
                                ->first();

            if ($contrato){
                return response()->json([
                    'status' => false,
                    'message' => 'Número de contrato já utilizado'
                ]);
            }else{
                return response()->json([
                    'status' => true
                ]);
            }
        }

        public function add_contrato(Request $request){
            if (!auth()->check()) {
                return redirect('/');
            }
            $user_id = auth()->user()->id;

            $numero_contrato = $request->numero_contrato;
            $id_contrato = $request->id_contrato;
            if (!$numero_contrato || !$request->for_cli_contrato || !$request->centro_custo_contrato || !$request->status_contrato) {
                return response()->json([
                    'status' => false,
                    'message' => 'Campos obrigatórios estão ausentes.'
                ]);
            }

            $contrato_existente = Contrato::where('id_usuario', $user_id)
                                        ->where('numero_contrato', $numero_contrato)
                                        ->first();

            if($contrato_existente && (!$id_contrato || $contrato_existente->id_contrato != $id_contrato)){
                return response()->json([
                    'status' => false,
                    'message' => 'Número de contrato já utilizado.'
                ]);
            }

            if($id_contrato){
                $contrato = Contrato::where('id_usuario', $user_id)
                                    ->where('id_contrato', $id_contrato)
                                    ->first();

                if(!$contrato){
                    return response()->json([
                        'status' => false,
                        'message' => 'Contrato não encontrado.'
                    ]);
                }
            }else{
                $contrato = new Contrato();
                $contrato->id_usuario = $user_id;
            }

            $contrato->id_produto = $request->produto_contrato;
            $contrato->valor = $request->valor_contrato;
            $contrato->status = $request->status_contrato;
            $contrato->data_inicio = $request->data_inicio_contrato;
            $contrato->data_fim = $request->data_fim_contrato;
            $contrato->data_reajuste = $request->data_reajuste_contrato;
            $contrato->data_pagamento = $request->data_vencimento_contrato;
            $contrato->id_for_cli = $request->for_cli_contrato;
            $contrato->numero_contrato = $numero_contrato;
            $contrato->descricao = $request->descricao_contrato;
            $contrato->id_centro_custo = $request->centro_custo_contrato;
            $contrato->save();

            return response()->json([
                'status' => true,
                'message' => 'Contrato salvo com sucesso.'
            ]);
        }

        public function agenda_contrato(Request $request){
            // Verifique se o usuário está autenticado
            $user_id = auth()->user()->id;
            if (!$user_id) {
                return response()->json(['status' => false, 'message' => 'Usuário não autenticado.']);
            }

            // Validação dos dados recebidos
            $validatedData = $request->validate([
                'agenda' => 'required',  // Certifique-se de que 'agenda' seja um array
                'id_contrato' => 'required|integer|exists:contratos,id_contrato', // Verifique se o contrato existe
            ]);

            $id_contrato = $validatedData['id_contrato'];
            $agenda = json_decode($validatedData['agenda'], true);

            // Atualize o campo agenda na tabela contratos
            $contrato = Contrato::find($id_contrato);
            if (!$contrato) {
                return response()->json(['status' => false, 'message' => 'Contrato não encontrado.']);
            }

            $contrato->agenda = $validatedData['agenda'];
            $contrato->save();

            // Apagar registros antigos na tabela agendas
            Agenda::where('contrato', 1)
                ->where('id_usuario', $user_id)
                ->whereDate('data', '>=', now()->startOfDay())
                ->delete();

            // Definir cor e título padrão
            $cor = '#800080'; // Roxo em hexadecimal

            // Obter o nome do cliente e do produto
            $fornecedorCliente = Fonecedor_cliente::where('id_for_cli', $contrato->id_for_cli)
                                                    ->where('id_usuario', $user_id)
                                                    ->first();
            $nome_cliente = $fornecedorCliente ? $fornecedorCliente->nome : 'Cliente Desconhecido';

            // Buscar produto pelo id_produto e id_usuario do contrato
            $produto = Produto::where('id_produto', $contrato->id_produto)
                                ->where('id_usuario', $user_id)
                                ->first();
            $nome_produto = $produto ? $produto->nome : 'Produto Desconhecido';

            // Gerar título
            $titulo = $nome_cliente . ' - ' . $nome_produto;
            // Criar eventos na tabela agendas
            $dias_da_semana = [
                'domingo' => '0',
                'segunda' => '1',
                'terca' => '2',
                'quarta' => '3',
                'quinta' => '4',
                'sexta' => '5',
                'sabado' => '6'
            ];
            if(isset($agenda['exibir_agenda']) && $agenda['exibir_agenda']) {
                foreach ($agenda['dias_semana'] as $dia => $aux ) {

                    $hora_inicio = $aux['hora_inicio'] ?? '00:00';
                    // Calcular o intervalo de datas
                    $hoje = now()->startOfDay(); // Dia de hoje
                    $fim_mes_atual = $hoje->copy()->endOfMonth(); // Último dia do mês atual

                    $inicio_mes_proximo = $fim_mes_atual->copy()->addDay(); // Primeiro dia do próximo mês
                    $fim_mes_proximo = $inicio_mes_proximo->copy()->endOfMonth(); // Último dia do próximo mês
                    // Gerar eventos para o mês atual
                    $this->criarEventos($user_id, $contrato->id_for_cli, $titulo, $dias_da_semana[$dia], $hora_inicio, $hoje, $fim_mes_atual);
                    // Gerar eventos para o próximo mês
                    $this->criarEventos($user_id, $contrato->id_for_cli, $titulo, $dias_da_semana[$dia], $hora_inicio, $inicio_mes_proximo, $fim_mes_proximo);
                }
            }

            return response()->json(['status' => true, 'message' => 'Agenda atualizada com sucesso.']);
        }

        private function criarEventos($user_id, $id_for_cli, $titulo, $dia_da_semana, $hora_inicio, $inicio, $fim)
        {

            $currentDate = $inicio->copy();
            while ($currentDate <= $fim) {

                if ($currentDate->dayOfWeek == $dia_da_semana) {
                    Agenda::create([
                        'id_usuario' => $user_id,
                        'id_for_cli' => $id_for_cli,
                        'titulo' => $titulo,
                        'cor' => '#800080',
                        'contrato' => 1,
                        'data' => $currentDate->format('Y-m-d') . ' ' . $hora_inicio,
                    ]);
                }
                $currentDate->addDay();
            }
        }



        public function get_agenda_contrato(Request $request){
            $id_contrato = $request->id_contrato;
            $contrato = Contrato::find($id_contrato);

            if (!$contrato) {
                return response()->json(['success' => false, 'message' => 'Contrato não encontrado.']);
            }
            if($contrato->agenda!='' || $contrato->agenda!=null){
                return response()->json([
                    'success' => true,
                    'agenda' => json_decode($contrato->agenda)  // Retornando o JSON da agenda
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'agenda' => ''
                ]);
            }

        }
        public function fornecedorCliente()
        {
            return $this->belongsTo(Fonecedor_cliente::class, 'id_for_cli');
        }

        public function produto()
        {
            return $this->belongsTo(Produto::class, 'id_produto');
        }
}
