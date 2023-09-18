<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Fonecedor_cliente;

class DocumentoController extends Controller
{
    
    public function dropzoneStorage(Request $request){
        $user_id = auth()->user()->id;
        $image= $request->file('file');
        $idCliFor=$request->id_cli_for;
        $extension=$image->extension();
        $tamanho=$image->getSize();
        // Get filename with the extension
        $filenameWithExt = $request->file('file')->getClientOriginalName();
        //Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = $request->file('file')->getClientOriginalExtension();
        // Filename to store
        $filename = trim($filename);
        $filename = str_replace(".", "", $filename);
        $filename = str_replace(",", "", $filename);
        $filename = str_replace("/", "", $filename);
        $filename = str_replace(" ", "", $filename);
        $fileNameToStore = $filename.'_'.time().'.'.$extension;

        $erro=0;
        $msg='';
        $total_size = 0;
        $path=storage_path('/app/public/documentos/'.$user_id.'/');
        if(Storage::disk('public')->exists('documentos/'.$user_id)){
            $files = scandir($path);
            foreach($files as $t) {
                if (is_dir(rtrim($path, '/') . '/' . $t)) {
                    if ($t<>"." && $t<>"..") {
                        $size = foldersize(rtrim($path, '/') . '/' . $t);
                        $total_size += $size;
                    }
                } else {
                    $size = filesize(rtrim($path, '/') . '/' . $t);
                    $total_size += $size;
                }   
            }
            if($total_size>30000000){
                $erro=1;
                $msg='Você atingiu o limite de 30MB';
            }
        }
        
        if($tamanho > 3000000){
            $erro=1;
            $msg='Arquivo excede tamanho máximo';
        }
        
        if($erro==0){
            $path = $request->file('file')->storeAs('public/documentos/'.$user_id,$fileNameToStore);
            if(true){
                //tipo=1 arquivo upload
                if($idCliFor!=''){

                    $documentos = new Documento;
                    $documentos->id_usuario=$user_id;
                    $documentos->nome=$filename;
                    $documentos->extensao=$extension;
                    $documentos->caminho=$fileNameToStore;
                    $documentos->tipo='3';
                    $documentos->id_for_cli=$idCliFor;

                    try{
                        $documentos->save();
                    }catch (\Exception $e) {
                        return response()->json(['status' => false, 'message' => 'Erro 703, tente novamente mais tarde ou entre em contado com suporte.']);
                    }

                    try {
                        $documentos = Documento::where('id_usuario', $user_id)->where('id_for_cli', $idCliFor)->orderBy('nome')->get();
                    } catch (\Exception $e) {
                        return response()->json(['status' => false, 'message' => 'Erro 701, tente novamente mais tarde ou entre em contado com suporte.']);
                    }
                }else{
                    $documentos = new Documento;
                    $documentos->id_usuario=$user_id;
                    $documentos->nome=$filename;
                    $documentos->extensao=$extension;
                    $documentos->caminho=$fileNameToStore;
                    $documentos->tipo='1';

                    try{
                        $documentos->save();
                    }catch (\Exception $e) {
                        return response()->json(['status' => false, 'message' => 'Erro 702, tente novamente mais tarde ou entre em contado com suporte.']);
                    }

                    try {
                        $documentos = Documento::where('id_usuario', $user_id)->where('tipo', '1')->orderBy('nome')->get();
                    } catch (\Exception $e) {
                        return response()->json(['status' => false, 'message' => 'Erro 704, tente novamente mais tarde ou entre em contado com suporte.']);
                    }
                }
                $html='';
                foreach($documentos as $item){
                    $fileNameParts = explode('.', $item->caminho);
                    
                    $icon='';
                    $tamanhoNome=strlen($item->nome);
                    $br='';
                    if($tamanhoNome<=25){
                      $br='<br><br>';
                    }else if($tamanhoNome<=50){
                      $br='<br>';
                    }
                    if($item->tipo!='2'){
                        $extension = end($fileNameParts);
                        switch($extension){
                            case 'pdf':
                                $icon='<i class="far fa-file-pdf"></i>';
                                break;
                            case 'doc' :
                            case 'docx':
                                $icon='<i class="far fa-file-word"></i>';
                                break;
                            case 'jpg' : case 'png' : case  'jpeg' : case  'webp':
                                $icon='<i class="fas fa-camera"></i>';
                                break;
                            default:
                                $icon='<i class="fas fa-paperclip"></i>';
                        }
                    }else{
                        $icon='<i class="fa-solid fa-pen-nib"></i>';
                    }
                    $appUrl = env('APP_URL');

                    $html.="<div class='col-lg-3 col-6' >
                            <!-- small card -->
                            <div class='small-box bg-info'>
                            <div class='inner'>
                                <p>$item->nome</p>
                                $br
                            </div>
                            <div class='icon'>
                                $icon
                            </div>
                            <div class='small-box-footer' >
                                <a href='$appUrl/documentos/download?id=$item->id'  class='btn btn-default btn-sm bg-success' >
                                <i class='fas fa-download'></i>
                                </a>
                                <a href='#' class='btn btn-default btn-sm bg-danger' onClick='deletar_documento(\"$item->nome\",$item->id)' >
                                <i class='fas fa-trash'></i>
                                </a>
                            </div>
                            </div>
                        </div>";
                }

                return response()->json(['status'=>$html]);
            }else{
                return response()->json(['status'=>'erro','msg'=>'Tente novamente mais tarde.']);
            }
        }else{
            return response()->json(['status'=>'erro','msg'=>$msg]);
        }
    }



    public function upload(){
        $user_id = auth()->user()->id;
        if($user_id){
            try {
                $documentos = Documento::where('id_usuario', $user_id)->where('tipo', '1')->orderBy('nome')->get();
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Erro 704, tente novamente mais tarde ou entre em contado com suporte.']);
            }

            return view ('documentos/upload',['documentos' => $documentos]);
        }else{
            return redirect('/');
        }
       
    }
    public function download(Request $request){
        $id=$request->id;
        $user_id = auth()->user()->id;
        try {
            $caminho = Documento::where('id_usuario', $user_id)->where('id', $id)->first();
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erro 704, tente novamente mais tarde ou entre em contado com suporte.']);
        }

        $path=storage_path('/app/public/documentos/'.$user_id.'/'.$caminho->caminho);
        return response()->download($path,$caminho->nome.'.'.$caminho->extensao);
    }

    public function del_documento(Request $request){
        $id=$request->id;
        $tipo=$request->tipo;
        $user_id = auth()->user()->id;
        if($tipo=='2' && $user_id && $id){
            Documento::where('id', $id)->where('id_usuario', $user_id)->delete();
        }else if($user_id && $id){

            $caminho = Documento::where('id_usuario', $user_id)->where('id', $id)->first();

            $path='documentos/'.$user_id.'/'.$caminho->caminho;
            if(Storage::disk('public')->exists($path)){
                Storage::disk('public')->delete($path);
                Documento::where('id', $id)->where('id_usuario', $user_id)->delete();
            }else{
                return response()->json(['status' => false, 'message' => 'Erro 705, tente novamente mais tarde ou entre em contado com suporte.']);
            }
        }else{
            return response()->json(['status' => false, 'message' => 'Erro 706, tente novamente mais tarde ou entre em contado com suporte.']);
        }
        return response()->json(['status' => true]);
    }

    public function escrever(){
        $user_id = auth()->user()->id;
        if($user_id){
            try {
                $documentos = Documento::where('id_usuario', $user_id)->where('tipo', '2')->orderBy('nome')->get();
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Erro 707, tente novamente mais tarde ou entre em contado com suporte.']);
            }

            $for_cli = Fonecedor_cliente::select('nome','id_for_cli')->where('id_usuario', $user_id)->orderBy('nome')->get();

            return view ('documentos/escrever',['documentos' => $documentos,'for_cli' => $for_cli]);
        }else{
            return redirect('/');
        }
       
    }

    public function add_escrever(Request $request){
        $titulo=$request->titulo_escrever;
        $for_cli=$request->for_cli_escrever;
        $user_id = auth()->user()->id;
        if($for_cli==''){
            $for_cli='null';
        }
        if($user_id && $titulo){
            //tipo=2 escrever
            $documentos = new Documento;
            $documentos->id_usuario=$user_id;
            $documentos->nome=$titulo;
            $documentos->tipo='2';
            $documentos->id_for_cli=$for_cli;
            try{
                $documentos->save();
            }catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Erro 708, tente novamente mais tarde ou entre em contado com suporte.']);
            }
        }else{
            return response()->json(['status' => false, 'message' => 'Erro 709, tente novamente mais tarde ou entre em contado com suporte.']);
        }
        return response()->json(['status' => true]);
    }

    public function editar(Request $request){
        $id=$request->id;
        $user_id = auth()->user()->id;
        if($user_id){
            try {
                $documentos = Documento::where('id_usuario', $user_id)->where('tipo', '2')->orderBy('nome')->get();
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Erro 710, tente novamente mais tarde ou entre em contado com suporte.']);
            }
            return view ('documentos/editar',['documentos' => $documentos]);
        }else{
            return redirect('/');
        }
       
    }

    public function editar_documento(Request $request){
        $id=$request->id;
        $user_id = auth()->user()->id;
        if($user_id && $id){
            try {
                $documentos = Documento::where('id_usuario', $user_id)->where('id', $id)->firstOrFail();
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Erro 711, tente novamente mais tarde ou entre em contado com suporte.']);
            }
            $documentos->texto = $request->get('texto');
            try{
                $documentos->save();
            }catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Erro 714, tente novamente mais tarde ou entre em contado com suporte.']);
            }
        }else{
            return response()->json(['status' => false, 'message' => 'Erro 712, tente novamente mais tarde ou entre em contado com suporte.']);
        }
        return response()->json(['status' => true]);
       
    }

    public function buscar_documentos(Request $request){
        $user_id = auth()->user()->id;
        if($user_id){

            $documentos = Documento::select('documentos.nome as nome','documentos.created_at as data_cria','documentos.tipo','documentos.extensao','documentos.id_for_cli','documentos.id','fornecedor_clientes.nome as for_cli')
            ->leftJoin('fornecedor_clientes','fornecedor_clientes.id_for_cli','=','documentos.id_for_cli')
            ->where('documentos.id_usuario',$user_id)
            ->when($request->for_cli_consulta_documentos, function ($query) use ($request) {
                return $query->whereIn('documentos.id_for_cli', $request->for_cli_consulta_documentos);
            })
            ->when(($request->data_inicio_consulta_documentos && $request->data_inicio_consulta_documentos!='0000-00-00' && $request->data_inicio_consulta_documentos!='00-00-0000'), function ($query) use ($request) {
                return $query->whereDate('documentos.created_at','>=', $request->data_inicio_consulta_documentos);
            })
            ->when(($request->data_fim_consulta_documentos && $request->data_fim_consulta_documentos!='0000-00-00' && $request->data_fim_consulta_documentos!='00-00-0000'), function ($query) use ($request) {
                return $query->whereDate('documentos.created_at','<=', $request->data_fim_consulta_documentos);
            })
            ->orderBy('documentos.nome')
            ->get();

            try {
                $for_cli = Fonecedor_cliente::where('id_usuario', $user_id)->orderBy('nome')->get();
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Erro 717, tente novamente mais tarde ou entre em contado com suporte.']);
            }
            

            return view ('documentos/buscar_documentos',['for_cli' => $for_cli,'documentos' => $documentos]);
        }else{
            return redirect('/');
        }
       
    }
    
    
    public function edita_documento(Request $request){

        $id = $request->id_documento;
        $nome = $request->nome_documento;
        $user_id = auth()->user()->id;
        
        if($user_id && $nome && $id){
            try {
                $documentos = Documento::where('id_usuario', $user_id)->where('id', $id)->firstOrFail();
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Erro 713, tente novamente mais tarde ou entre em contado com suporte.']);
            }
            $documentos->id_for_cli = $request->get('for_cli_documentos');
            $documentos->nome = $nome;
            try{
                $documentos->save();
            }catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Erro 715, tente novamente mais tarde ou entre em contado com suporte.']);
            }

        }else{
            return response()->json(['status' => false, 'message' => 'Erro 716, tente novamente mais tarde ou entre em contado com suporte.']);
        }
        return response()->json(['status' => true]);
    }

    
}
