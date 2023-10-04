<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lancamento;
use App\Models\Produto;
use App\Models\Centro_custo;
use App\Models\Fonecedor_cliente;
use App\Models\Statu;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class LancamentoController extends Controller
{

    public function contas_receber(){
        return $this->contas(1);
    }
    public function contas_pagar(){
        return $this->contas(2);
    }
    public function contas_all(){
        return $this->contas();
    }

    public function consulta_contas_receber(Request $request){
        return $this->consulta_contas(1,$request);
    }
    public function consulta_contas_pagar(Request $request){
        return $this->consulta_contas(2,$request);
    }

    public function consulta_fluxo_caixa(Request $request){
        return $this->consulta_contas(3,$request);
    }

    
    public function contas($aux=null){
        $user_id = auth()->user()->id;
        if($user_id) {
            $query = Lancamento::query();
            $query->select(['lancamentos.id_produto', 'lancamentos.id_lancamento', 'lancamentos.descricao', 'lancamentos.id_for_cli', 'lancamentos.valor', 'lancamentos.data_vencimento', 'produtos.nome as produto', 'produtos.id_produto as id_produto', 'fornecedor_clientes.nome as for_cli', 'fornecedor_clientes.id_for_cli as id_for_cli', 'centro_custos.nome as centro_custos', 'centro_custos.id_centro_custo as id_centro_custo', 'status.nome as status', 'status.id_status as id_status', 'lancamentos.tipo']);
            $query->leftJoin('produtos', 'produtos.id_produto', '=', 'lancamentos.id_produto');
            $query->leftJoin('centro_custos', 'centro_custos.id_centro_custo', '=', 'lancamentos.id_centro_custo');
            $query->leftJoin('fornecedor_clientes', 'fornecedor_clientes.id_for_cli', '=', 'lancamentos.id_for_cli');
            $query->leftJoin('status', 'status.id_status', '=', 'lancamentos.id_status');
            $query->where('lancamentos.id_usuario', $user_id);
            if($aux){
                $query->where('lancamentos.tipo', $aux);
            }
            $query->orderBy('lancamentos.data_vencimento', 'DESC');
            $lancamentos = $query->get();
            $produto = Produto::select('nome','id_produto')->where('id_usuario', $user_id)->orderBy('nome')->get();
            $for_cli = Fonecedor_cliente::select('nome','id_for_cli')->where('id_usuario', $user_id)->orderBy('nome')->get();
            $centro_custo = Centro_custo::select('nome','id_centro_custo')->where('id_usuario', $user_id)->where('status', '1')->orderBy('nome')->get();
            $status = Statu::select('nome','id_status')->where('status', '1')->orderBy('nome')->get();



            return view ('financeiro/contas',['tipo' => $aux,'lancamentos' => $lancamentos,'status' => $status, 'produtos' =>$produto,'for_cli' => $for_cli, 'centro_custo' => $centro_custo]);
        }else{
            return redirect('/');
        }
    }

    public function consulta_contas($tipoAux=null,$request=null){
        $user_id = auth()->user()->id;
        if($user_id){
            $array_input = [];
            $array_data = [];
            $query = Lancamento::query();
            $query->select(['lancamentos.id_produto', 'lancamentos.id_lancamento', 'lancamentos.descricao', 'lancamentos.id_for_cli', 'lancamentos.valor', 'lancamentos.data_vencimento', 'produtos.nome as produto', 'produtos.id_produto as id_produto', 'fornecedor_clientes.nome as for_cli', 'fornecedor_clientes.id_for_cli as id_for_cli', 'centro_custos.nome as centro_custos', 'centro_custos.id_centro_custo as id_centro_custo', 'status.nome as status', 'status.id_status as id_status', 'lancamentos.tipo']);
            $query->leftJoin('produtos', 'produtos.id_produto', '=', 'lancamentos.id_produto');
            $query->leftJoin('centro_custos', 'centro_custos.id_centro_custo', '=', 'lancamentos.id_centro_custo');
            $query->leftJoin('fornecedor_clientes', 'fornecedor_clientes.id_for_cli', '=', 'lancamentos.id_for_cli');
            $query->leftJoin('status', 'status.id_status', '=', 'lancamentos.id_status');
            $query->where('lancamentos.id_usuario', $user_id);
            
           if($tipoAux && $tipoAux == '3'){
            $query->where('lancamentos.id_status', '1');
            }else{
                $query->where('lancamentos.tipo', $tipoAux);
            }
            if($request->has('centro_custos_consulta_contas')){
                $array_input['centro_custos'] = $request->centro_custos_consulta_contas;
                $query->whereIn('lancamentos.id_centro_custo', $request->centro_custos_consulta_contas);
            }
             
            if($request->has('for_cli_consulta_contas')){
                $array_input['for_cli'] = $request->for_cli_consulta_contas;
                $query->whereIn('lancamentos.id_for_cli', $request->for_cli_consulta_contas);
            }
            
            if($request->has('status_consulta_contas')){
                $array_input['status'] = $request->status_consulta_contas;
                $query->whereIn('lancamentos.id_status', $request->status_consulta_contas);
            }
            
            if($request->has('produto_consulta_contas')){
                $array_input['produto'] = $request->produto_consulta_contas;
                $query->whereIn('lancamentos.id_produto', $request->produto_consulta_contas);
            }
            if($request->has('data_inicio_consulta_contas') && $request->data_inicio_consulta_contas){
                $array_data['inicio'] = $request->data_inicio_consulta_contas;
                $query->where('lancamentos.data_vencimento', '>=', $request->data_inicio_consulta_contas);
            }
            
            if($request->has('data_fim_consulta_contas') && $request->data_fim_consulta_contas){
                $array_data['fim'] = $request->data_fim_consulta_contas;
                $query->where('lancamentos.data_vencimento', '<=', $request->data_fim_consulta_contas);
            }
            $query->orderBy('lancamentos.data_vencimento', 'desc');
            $lancamentos = $query->get();
       
            $produto = Produto::select('nome','id_produto')->where('id_usuario', $user_id)->orderBy('nome')->get();
            $for_cli = Fonecedor_cliente::select('nome','id_for_cli')->where('id_usuario', $user_id)->orderBy('nome')->get();
            $centro_custo = Centro_custo::select('nome','id_centro_custo')->where('id_usuario', $user_id)->where('status', '1')->orderBy('nome')->get();
            $status = Statu::select('nome','id_status')->where('status', '1')->orderBy('nome')->get();

            switch ($tipoAux) {
                case 3:
                    $query = Lancamento::query();
                    $query->selectRaw("lancamentos.data_vencimento, MONTH(lancamentos.data_vencimento) AS mes, 
                                FORMAT(SUM(CASE WHEN tipo = '1' THEN valor ELSE 0 END),2) AS entrada,
                                FORMAT(SUM(CASE WHEN tipo = '2' THEN valor ELSE 0 END),2) AS saida")
                ->leftJoin("produtos", "produtos.id_produto", "=", "lancamentos.id_produto")
                ->leftJoin("centro_custos", "centro_custos.id_centro_custo", "=", "lancamentos.id_centro_custo")
                ->leftJoin("fornecedor_clientes", "fornecedor_clientes.id_for_cli", "=", "lancamentos.id_for_cli")
                ->leftJoin("status", "status.id_status", "=", "lancamentos.id_status")
                ->where('lancamentos.id_usuario', $user_id)
                ->when($tipoAux && $tipoAux != 3, function($query) use ($tipoAux) {
                    return $query->where("tipo", $tipoAux);
                })
                ->when($tipoAux == 3, function($query) {
                    return $query->where("lancamentos.id_status", 1);
                });

                if ($request->centro_custos_consulta_contas) {
                    $query->whereIn("lancamentos.id_centro_custo", $request->centro_custos_consulta_contas);
                }

                if ($request->for_cli_consulta_contas) {
                    $query->whereIn("lancamentos.id_for_cli", $request->for_cli_consulta_contas);
                }

                if ($request->status_consulta_contas) {
                    $query->whereIn("lancamentos.id_status", $request->status_consulta_contas);
                }

                if ($request->produto_consulta_contas) {
                    $query->whereIn("lancamentos.id_produto", $request->produto_consulta_contas);
                }
                if ($request->filled('data_inicio_consulta_contas') && !$request->filled('data_fim_consulta_contas')) {
                    $query->whereDate('lancamentos.data_vencimento', '>=', Carbon::parse($request->data_inicio_consulta_contas))
                          ->whereDate('lancamentos.data_vencimento', '<=', Carbon::parse($request->data_inicio_consulta_contas)->addMonths(6));
                } else if (!$request->filled('data_inicio_consulta_contas') && $request->filled('data_fim_consulta_contas')) {
                    $query->whereDate('lancamentos.data_vencimento', '>=', Carbon::parse($request->data_fim_consulta_contas)->subMonths(6))
                          ->whereDate('lancamentos.data_vencimento', '<=', Carbon::parse($request->data_fim_consulta_contas));
                } else if ($request->filled('data_inicio_consulta_contas') && $request->filled('data_fim_consulta_contas')) {
                    $query->whereDate('lancamentos.data_vencimento', '>=', Carbon::parse($request->data_inicio_consulta_contas))
                          ->whereDate('lancamentos.data_vencimento', '<=', Carbon::parse($request->data_fim_consulta_contas));
                } else {
                    $query->whereDate('lancamentos.data_vencimento', '>=', Carbon::now()->subMonths(6))
                          ->whereDate('lancamentos.data_vencimento', '<=', Carbon::now());
                }
                $query->groupBy('mes');
                $query->orderBy('lancamentos.data_vencimento', 'asc');
                $grafico = $query->get();
                    break;
                default:
                    $grafico=[];
                    break;
            }
            return view ('financeiro/consulta_contas',['grafico'=> $grafico,'array_data'=> $array_data,'array_input'=> $array_input,'tipo' => $tipoAux,'lancamentos' => $lancamentos,'status' => $status, 'produtos' =>$produto,'for_cli' => $for_cli, 'centro_custo' => $centro_custo]);
            
        }else{
            return redirect('/');
        }
       
    }

    public function add(Request $request){
        $tipo = $request->tipo_contas;
        $valor = $request->valor_contas;
        $descricao = $request->descricao_contas;
        $produto = $request->produto_contas;
        $status_input = $request->status_contas;
        $centro_custos = $request->centro_custos_contas;
        $for_cli = $request->for_cli_contas;
        $data_vencimento = $request->data_vencimento_contas;
        $repeticao = $request->repeticao_contas;
        $qut = $request->qut_contas;
        $parcelas = $request->qut_contas_cartao;
        $id = $request->id_contas;
        $pag_contas = $request->pag_contas;

        $valor = str_replace('.','',$valor);
        $valor = str_replace(',','.',$valor);
        
        $user_id = auth()->user()->id;

        if($user_id && $valor){
            if($id!=''){
                try {
                    $lancamento = Lancamento::where('id_usuario', $user_id )->where('id_lancamento', $id)->firstOrFail();
                } catch (\Exception $e) {
                    return response()->json(['status' => false, 'message' => 'Erro 303, tente novamente mais tarde ou entre em contado com suporte.']);
                }
                
                $lancamento->valor=$valor;
                $lancamento->descricao=$descricao;
                $lancamento->id_produto=$produto;
                $lancamento->id_status=$status_input;
                $lancamento->id_centro_custo=$centro_custos;
                $lancamento->id_for_cli=$for_cli;
                $lancamento->data_vencimento=$data_vencimento;
                try{
                    $lancamento->save();
                }catch (\Exception $e) {
                    return response()->json(['status' => false, 'message' => 'Erro 304, tente novamente mais tarde ou entre em contado com suporte.']);
                }
            }else{
                
                    if($repeticao>=1 && $qut>=1){  
                        $lancamento = new Lancamento;
                        $lancamento->valor=$valor;
                        $lancamento->descricao=$descricao;
                        $lancamento->id_produto=$produto;
                        $lancamento->id_status=$status_input;
                        $lancamento->id_centro_custo=$centro_custos;
                        $lancamento->id_for_cli=$for_cli;
                        $lancamento->data_vencimento=$data_vencimento;
                        $lancamento->tipo=$tipo;
                        $lancamento->id_usuario = $user_id;
                        try{
                            $lancamento->save();
                        }catch (\Exception $e) {
                            return response()->json(['status' => false, 'message' => 'Erro 301, tente novamente mais tarde ou entre em contado com suporte.']);
                        } 
                        $data_vencimento_aux=$data_vencimento;
                        for($i=1;$i<=$qut;$i++){
                            switch ($repeticao) {
                                case 1:
                                    $data_vencimento = date('Y-m-d', strtotime($data_vencimento. ' + 1 days'));
                                    break;
                                case 2:
                                    $data_vencimento = date('Y-m-d', strtotime($data_vencimento. ' + 7 days'));
                                    break;
                                case 3:
                                    $data_vencimento = date('Y-m-d', strtotime($data_vencimento. ' + 15 days'));
                                    break;
                                case 4:
                                    $dia= date('d', strtotime($data_vencimento_aux));
                                    $mes= date('m', strtotime($data_vencimento_aux));
                                    $ano = date('Y', strtotime($data_vencimento_aux. " + $i months"));
                                    $data_aux=$ano.'-'.$mes.'-1';
                                    $mes = date('m', strtotime($data_aux. " + $i months"));
                                    $data_aux="$ano-$mes-1";
                                    
                                    if('31'==$dia ||  ($mes==2 && $dia>=29 )){
                                        $dataDateTime = Carbon::createFromFormat("Y-m-d", $data_aux);
                                        $data_vencimento = $dataDateTime->endOfMonth();;
                                    }else{
                                        $data_vencimento = date('Y-m-d', strtotime($data_vencimento_aux. " + $i months"));
                                    }
                                    break;
                            }
                            $lancamento = new Lancamento;
                            $lancamento->valor=$valor;
                            $lancamento->descricao=$descricao;
                            $lancamento->id_produto=$produto;
                            $lancamento->id_status='2';
                            $lancamento->id_centro_custo=$centro_custos;
                            $lancamento->id_for_cli=$for_cli;
                            $lancamento->data_vencimento=$data_vencimento;
                            $lancamento->tipo=$tipo;
                            $lancamento->id_usuario = $user_id;
                            try{
                                $lancamento->save();
                            }catch (\Exception $e) {
                                return response()->json(['status' => false, 'message' => 'Erro 305, tente novamente mais tarde ou entre em contado com suporte.']);
                            } 
                        }
                    }else{
                        $lancamento = new Lancamento;
                        $lancamento->valor=$valor;
                        $lancamento->descricao=$descricao;
                        $lancamento->id_produto=$produto;
                        $lancamento->id_status=$status_input;
                        $lancamento->id_centro_custo=$centro_custos;
                        $lancamento->id_for_cli=$for_cli;
                        $lancamento->data_vencimento=$data_vencimento;
                        $lancamento->tipo=$tipo;
                        $lancamento->id_usuario = $user_id;
                        try{
                            $lancamento->save();
                        }catch (\Exception $e) {
                            return response()->json(['status' => false, 'message' => 'Erro 302, tente novamente mais tarde ou entre em contado com suporte.']);
                        }        
                    }
                
            }
        }else{
            return response()->json(['status' => false, 'message' => 'Erro 202, tente novamente mais tarde ou entre em contado com suporte.']);
        }
        return response()->json(['status' => true]);
    }
    
    
    
    public function saldo_inicial(Request $request){
        $saldo = $request->saldo;
        $saldo = str_replace('.','',$saldo);
        $saldo = str_replace(',','.',$saldo);
        $user_id = auth()->user()->id;
        if($user_id && $saldo){
            $lancamento = new Lancamento;
            $lancamento->valor=$saldo;
            $lancamento->descricao='Saldo inicial';
            $lancamento->id_produto='0';
            $lancamento->id_status='1';
            $lancamento->id_centro_custo='0';
            $lancamento->id_for_cli='0';
            $lancamento->data_vencimento=date("Y-m-d");
            $lancamento->tipo='1';
            $lancamento->id_usuario = $user_id;
            try{
                $lancamento->save();
                return response()->json(['status' => true]);
            }catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Erro 220, tente novamente mais tarde ou entre em contado com suporte.']);
            } 
        }else{
            return response()->json(['status' => false, 'message' => 'Erro 221, tente novamente mais tarde ou entre em contado com suporte.']);
        }
    }
    
    

    public function del(Request $request){

        $id = $request->id_contas;
        $user_id = auth()->user()->id;
        if($user_id && $id){
            Lancamento::where('id_lancamento', $id)->where('id_usuario', $user_id)->delete();
            $status['status']=true;
        }else{
            $status['status']=false;
        }
        echo json_encode($status);
    }

    public function consulta_centro_custo(Request $request){
        $user_id = auth()->user()->id;

        if($user_id){
            $array_input=[];
            $array_data=[];
            $aux_centro_custo='';

            $query = Lancamento::query();
            $query->selectRaw("centro_custos.nome as descricao,
                            SUM( CASE WHEN tipo =1 THEN valor ELSE 0 END ) AS saldo, 
                            SUM( CASE WHEN tipo =2 THEN valor ELSE 0 END ) AS debito ")
                ->leftJoin("produtos", "produtos.id_produto", "=", "lancamentos.id_produto")
                ->leftJoin("centro_custos", "centro_custos.id_centro_custo", "=", "lancamentos.id_centro_custo")
                ->leftJoin("fornecedor_clientes", "fornecedor_clientes.id_for_cli", "=", "lancamentos.id_for_cli")
                ->leftJoin("status", "status.id_status", "=", "lancamentos.id_status")
                ->where('lancamentos.id_usuario', $user_id)
                ->where('lancamentos.id_centro_custo', "<>", '0');
                if($request->has('centro_custos_consulta_contas')){
                    $array_input['centro_custos'] = $request->centro_custos_consulta_contas;
                    $query->whereIn('lancamentos.id_centro_custo', $request->centro_custos_consulta_contas);
                }
                 
                if($request->has('for_cli_consulta_contas')){
                    $array_input['for_cli'] = $request->for_cli_consulta_contas;
                    $query->whereIn('lancamentos.id_for_cli', $request->for_cli_consulta_contas);
                }
                
                if($request->has('status_consulta_contas')){
                    $array_input['status'] = $request->status_consulta_contas;
                    $query->whereIn('lancamentos.id_status', $request->status_consulta_contas);
                }
                
                if($request->has('produto_consulta_contas')){
                    $array_input['produto'] = $request->produto_consulta_contas;
                    $query->whereIn('lancamentos.id_produto', $request->produto_consulta_contas);
                }
                if($request->has('data_inicio_consulta_contas') && $request->data_inicio_consulta_contas){
                    $array_data['inicio'] = $request->data_inicio_consulta_contas;
                    $query->where('lancamentos.data_vencimento', '>=', $request->data_inicio_consulta_contas);
                }
                
                if($request->has('data_fim_consulta_contas') && $request->data_fim_consulta_contas){
                    $array_data['fim'] = $request->data_fim_consulta_contas;
                    $query->where('lancamentos.data_vencimento', '<=', $request->data_fim_consulta_contas);
                }

            $query->groupBy('lancamentos.id_centro_custo');
            $query->orderBy('centro_custos.nome', 'asc');
            $lancamentos = $query->get();

            $produto = Produto::select('nome','id_produto')->where('id_usuario', $user_id)->orderBy('nome')->get();
            $for_cli = Fonecedor_cliente::select('nome','id_for_cli')->where('id_usuario', $user_id)->orderBy('nome')->get();
            $centro_custo = Centro_custo::select('nome','id_centro_custo')->where('id_usuario', $user_id)->where('status', '1')->orderBy('nome')->get();
            $status = Statu::select('nome','id_status')->where('status', '1')->orderBy('nome')->get();

            return view ('financeiro/consulta_centro_custo',['array_data'=> $array_data,'array_input'=> $array_input,'lancamentos' => $lancamentos,'status' => $status, 'produtos' =>$produto,'for_cli' => $for_cli, 'centro_custo' => $centro_custo]);
           
        }else{
            return redirect('/');
        }
       
    }
    
}
