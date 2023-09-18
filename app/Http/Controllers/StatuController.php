<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statu;
use Illuminate\Support\Facades\DB;

class StatuController extends Controller
{
    
    public function index(){
     
        $user_id = auth()->user()->id;
        if($user_id){
            $sql = "SELECT nome,id_status,status FROM status
                        WHERE id_usuario=$user_id";
            $status = DB::select($sql);
          
            return view ('financeiro/status',['status' => $status]);

        }else{
            return redirect('/');
        }
       
    }

    public function add_status(Request $request){

        $nome = $request->nome;
        $ativo = $request->ativo;
        $id = $request->id;
        $user_id = auth()->user()->id;
        if($ativo=='on'){
            $ativo=1;
        }else{
            $ativo=0;
        }
        if($user_id && $nome){
            if($id!=''){
                $sql = "UPDATE status
                            SET nome = '$nome',
                            status = '$ativo',
                            data_altera='".date("Y-m-d h:i:s")."'
                            WHERE id_status=$id 
                            AND id_usuario=$user_id ";
            }else{
                $sql = "INSERT INTO status(id_usuario,nome,data_cria,status) 
                            VALUES($user_id,'$nome','".date("Y-m-d h:i:s")."','$ativo')";
            }

            $query = DB::select($sql);
            $status['status']=true;
        }else{
            $status['status']=false;
        }
        echo json_encode($status);
    }

}
