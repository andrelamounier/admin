<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fonecedor_cliente;
use App\Models\Lancamento;
use App\Models\Documento;
use App\Models\Agenda;
use App\Models\Produto;
use App\Models\Centro_custo;
use App\Models\Statu;
use Illuminate\Support\Facades\DB;

class Fonecedor_clienteController extends Controller
{
    
    public function index(){
     
        $user_id = auth()->user()->id;
        if($user_id){
            try {
                $for_cli = Fonecedor_cliente::where('id_usuario', $user_id)->orderBy('nome')->get();
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Erro 917, tente novamente mais tarde ou entre em contado com suporte.']);
            }
            return view ('fonecedor_cliente/fonecedor_cliente',['for_cli' => $for_cli]);
            
        }else{
            return redirect('/');
        }
       
    }

    public function add_for_cli(Request $request){

        $nome = $request->nome_for_cli;
        $descricao = $request->descricao_for_cli;
        $cpfcnpj = $request->cpfcnpj_for_cli;
        $cep = $request->cep_for_cli;
        $rua = $request->rua_for_cli;
        $bairro = $request->bairro_for_cli;
        $cidade = $request->cidade_for_cli;
        $estado = $request->estado_for_cli;
        $numero = $request->numero_for_cli;
        $telefone = $request->telefone_for_cli;
        $complemento = $request->complemento_for_cli;
        $email = $request->email_for_cli;
        $id = $request->id_for_cli;
        $tipo = $request->tipo_for_cli;
        $user_id = auth()->user()->id;

        if($user_id && $nome){
            if($id){
                try {
                    $fornecedor_clientes = Fonecedor_cliente::where('id_for_cli', $id)->where('id_usuario', $user_id)->firstOrFail();
                } catch (\Exception $e) {
                    return response()->json(['status' => false, 'message' => 'Erro 901, tente novamente mais tarde ou entre em contado com suporte.']);
                }
                $fornecedor_clientes->nome = $nome;
                $fornecedor_clientes->descricao = $descricao;
                $fornecedor_clientes->cpfcnpj = $cpfcnpj;
                $fornecedor_clientes->cep = $cep;
                $fornecedor_clientes->rua = $rua;
                $fornecedor_clientes->bairro = $bairro;
                $fornecedor_clientes->cidade = $cidade;
                $fornecedor_clientes->estado = $estado;
                $fornecedor_clientes->numero = $numero;
                $fornecedor_clientes->telefone = $telefone;
                $fornecedor_clientes->complemento = $complemento;
                $fornecedor_clientes->email = $email;
                try{
                    $fornecedor_clientes->save();
                }catch (\Exception $e) {
                    return response()->json(['status' => false, 'message' => 'Erro 902, tente novamente mais tarde ou entre em contado com suporte.']);
                }
            }else{
                $verifica_unico = Fonecedor_cliente::where('id_usuario', $user_id )->where('nome', $nome)->first();
                if(!$verifica_unico){
                    $fornecedor_clientes = new Fonecedor_cliente;
                    $fornecedor_clientes->nome = $nome;
                    $fornecedor_clientes->descricao = $descricao;
                    $fornecedor_clientes->cpfcnpj = $cpfcnpj;
                    $fornecedor_clientes->cep = $cep;
                    $fornecedor_clientes->rua = $rua;
                    $fornecedor_clientes->bairro = $bairro;
                    $fornecedor_clientes->cidade = $cidade;
                    $fornecedor_clientes->estado = $estado;
                    $fornecedor_clientes->numero = $numero;
                    $fornecedor_clientes->telefone = $telefone;
                    $fornecedor_clientes->complemento = $complemento;
                    $fornecedor_clientes->email = $email;
                    $fornecedor_clientes->id_usuario = $user_id;
                    try{
                        $fornecedor_clientes->save();
                    }catch (\Exception $e) {
                        return response()->json(['status' => false, 'message' => 'Erro 903, tente novamente mais tarde ou entre em contado com suporte.']);
                    }
                }else{
                    return response()->json(['status' => false, 'message' => 'Já existe um Cliente - Fornecedor com esse nome.']);
                }
            }
        }else{
            return response()->json(['status' => false, 'message' => 'Erro 904, preencha o campo nome.']);
        }
        return response()->json(['status' => true]);
    }
    
    public function fornecedor_cliente(Request $request){
        $user_id = auth()->user()->id;
        if($user_id){
            $array= array(
                'Cemig'=>$request->cemig,
                'Copasa'=>$request->copasa,
                'Tim'=>$request->tim,
                'Vivo'=>$request->vivo,
                'Oi'=>$request->oi,
                'Claro'=>$request->claro,
                'Supermercado'=>$request->supermercado,
                'Indefinido'=>$request->indefinido
                );
            foreach($array as $k =>$item){
                if($item==1){
                    $fornecedor_clientes = new Fonecedor_cliente;
                    $fornecedor_clientes->id_usuario=$user_id;
                    $fornecedor_clientes->nome=$k;
                    $fornecedor_clientes->save();
                }
            }
            $status['status']= true;
        }else{
            $status['status']=false;
        }
        echo json_encode($status);
    }

    public function perfil(Request $request){
        $user_id = auth()->user()->id;
        $id = $request->id;
        if($id!='' && $user_id!=''){
            
            $qut_lancamentos = Lancamento::where('id_usuario', $user_id)->where('id_for_cli',$id)->count();
            $qut_documentos = Documento::where('id_usuario', $user_id)->where('id_for_cli',$id)->count();
            $documentos = Documento::where('id_usuario', $user_id)->where('id_for_cli',$id)->get();

            $lancamentos = Lancamento::select('lancamentos.id_produto','id_lancamento','lancamentos.descricao','lancamentos.id_for_cli',
            'valor','data_vencimento','produtos.nome AS produto','produtos.id_produto AS id_produto','fornecedor_clientes.nome as for_cli',
            'fornecedor_clientes.id_for_cli AS id_for_cli','centro_custos.nome as centro_custos','centro_custos.id_centro_custo as id_centro_custo',
            'status.nome as status','status.id_status as id_status','lancamentos.tipo')
            ->leftJoin('produtos','produtos.id_produto','=','lancamentos.id_produto')
            ->leftJoin('centro_custos','centro_custos.id_centro_custo','=','lancamentos.id_centro_custo')
            ->leftJoin('fornecedor_clientes','fornecedor_clientes.id_for_cli','=','lancamentos.id_for_cli')
            ->leftJoin('status','status.id_status','=','lancamentos.id_status')
            ->where('lancamentos.id_usuario',$user_id)
            ->where('lancamentos.id_for_cli',$id)
            ->orderBy('id_lancamento','desc')
            ->get();

            $for_cli = Fonecedor_cliente::where('id_usuario', $user_id)->where('id_for_cli',$id)->get();
            $for_cli_all = Fonecedor_cliente::select('nome','id_for_cli')->where('id_usuario', $user_id)->orderBy('nome')->get();
            $agendas = Agenda::where('id_usuario', $user_id)->where('id_for_cli',$id)->get();
            $centro_custo = Centro_custo::select('nome','id_centro_custo')->where('id_usuario', $user_id)->where('status', '1')->orderBy('nome')->get();
            $produto = Produto::select('nome','id_produto')->where('id_usuario', $user_id)->orderBy('nome')->get();
            $status = Statu::select('nome','id_status')->where('status', '1')->orderBy('nome')->get();


            return view ('fonecedor_cliente/perfil',['status' => $status, 'produtos' => $produto, 'centro_custo' => $centro_custo, 'for_cli_all' => $for_cli_all,'agendas' => $agendas,'documentos' => $documentos,'for_cli' => $for_cli,'lancamentos' => $lancamentos,'qut_lancamentos'=>$qut_lancamentos,'qut_documentos'=>$qut_documentos]);
        }else{
            return redirect('/');
        }
    }

    function buscar_fc(){
        $user_id = auth()->user()->id;
        try {
            $for_cli = Fonecedor_cliente::where('id_usuario', $user_id)->orderBy('nome')->get();
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erro 717, tente novamente mais tarde ou entre em contado com suporte.']);
        }
        $status['options']='';
        foreach($for_cli as $item){
            $status['options'].="<option value='$item->id_for_cli'>$item->nome</option>";
        }
        $status['status']= true;
        echo json_encode($status);
    }
}
