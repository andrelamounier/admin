<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projeto;
use Illuminate\Support\Facades\DB;

class ProjetoController extends Controller
{
    
    public function index(){
     
       
    }
    public function add_projeto(Request $request){
        $user_id = auth()->user()->id;
        $titulo = $request->titulo_cria_tarefas;
        $descricao = $request->descricao_cria_tarefas;
        $data = $request->data_cria_tarefas;
        $statusaux = $request->status_cria_tarefas;
        $lista = $request->lista_cria_tarefas;
        $jsonLista = $request->jsonLista;
        $id = $request->id_cria_tarefas;
        $listaaux='';
        $i=1;
        if($lista!=''){
             foreach($lista as $item){
                if($item!=''){
                    $listaaux.='{
                                "input": "",
                                "text": "'.$item.'"
                            },';
                    $i++;
                }
                
            }
        }
           
        $listaaux=substr($listaaux, 0, -1);
        $listaaux="[".$listaaux;
        $listaaux.="]";
        if($jsonLista!='' && $listaaux=='[]'){
            $listaaux=$jsonLista;
        }
        if($user_id && $titulo && $statusaux){
            if($id!=''){
                try {
                    $projeto = Projeto::where('id', $id)->where('id_usuario', $user_id)->firstOrFail();
                } catch (\Exception $e) {
                    return response()->json(['status' => false, 'message' => 'Erro 101, tente novamente mais tarde ou entre em contado com suporte.']);
                }
                $projeto->titulo = $titulo;
                $projeto->descricao = $descricao;
                $projeto->data = $data;
                $projeto->lista = $jsonLista;
                $projeto->status = $statusaux;
                try{
                    $projeto->save();
                }catch (\Exception $e) {
                    return response()->json(['status' => false, 'message' => 'Erro 109, tente novamente mais tarde ou entre em contado com suporte.']);
                }
                            
            }else{
                $projeto = new Projeto;
                $projeto->titulo = $titulo;
                $projeto->descricao = $descricao;
                $projeto->data = $data;
                $projeto->lista = $listaaux;
                $projeto->status = $statusaux;
                $projeto->id_usuario = $user_id;
                try{
                    $projeto->save();
                }catch (\Exception $e) {
                    return response()->json(['status' => false, 'message' => 'Erro 103, tente novamente mais tarde ou entre em contado com suporte.']);
                }
            }
        }else{
            return response()->json(['status' => false, 'message' => 'Erro 103, tente novamente mais tarde ou entre em contado com suporte.']);
        }
        return response()->json(['status' => true]);
    }

    public function tarefas(){
        $user_id = auth()->user()->id;
        if($user_id){
            $tarefas = Projeto::where('id_usuario', $user_id)->orderBy('data')->get();
            return view ('projetos/tarefas',['tarefas' => $tarefas]);
        }else{
            return redirect('/');
        }
    }

    public function altera_check(Request $request){
        $user_id = auth()->user()->id;
        $id = $request->id;
        $posicao = $request->posicao;
        $check = $request->check;
        

        if($user_id!='' && $id!='' && $posicao!=''){

            $sql = "SELECT lista FROM projetos WHERE id=$id AND id_usuario=$user_id ";
            $lista = DB::select($sql);

            
            $array = json_decode(json_encode($lista), true);
            $aux='';
            foreach($array as $item){
                foreach($item as $value){
                    $aux=$value;
                }
            }
            $jsonText = $aux;
            $decodedText = html_entity_decode($jsonText);
            $myArray = json_decode($decodedText, true);
            $myArray[$posicao]['input']=$check;
            $myArray=json_encode($myArray);

            try {
                $projeto = Projeto::where('id', $id)->where('id_usuario', $user_id)->firstOrFail();
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Erro 106, tente novamente mais tarde ou entre em contado com suporte.']);
            }
            
            $projeto->lista = $myArray;
            try{
                $projeto->save();
            }catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Erro 108, tente novamente mais tarde ou entre em contado com suporte.']);
            }
        }else{
            return response()->json(['status' => false, 'message' => 'Erro 107, tente novamente mais tarde ou entre em contado com suporte.']);
        }
        return response()->json(['status' => true]);
    }

    function del_tarefa(Request $request){
        $user_id = auth()->user()->id;
        $id = $request->id;
        if($user_id && $id){
            Projeto::where('id', $id)->where('id_usuario', $user_id)->delete();
        }else{
            return response()->json(['status' => false, 'message' => 'Erro 105, tente novamente mais tarde ou entre em contado com suporte.']);
        }
        return response()->json(['status' => true]);
    }
}
