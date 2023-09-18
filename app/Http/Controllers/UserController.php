<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Fortify;
use App\Models\User;
use App\Models\Lancamento;
use App\Models\Projeto;
use App\Models\Fonecedor_cliente;
use App\Models\Agenda;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index(){
        if(!auth()->user()->primeiro_acesso){
            return view('/cadastro_inicial');
            exit;
        }
        $user_id = auth()->user()->id;

        $lancamentos = Lancamento::select('valor','tipo','id_status','data_vencimento')->where('id_usuario', $user_id)->orderBy('data_vencimento')->get();

        $data_inicio=date("Y-m-d",mktime(0,0,0,date('m')-6,1));

        $lancamentos_semestral = Lancamento::select('valor','tipo','data_vencimento')
            ->where('id_usuario', $user_id)
            ->whereBetween('data_vencimento', [
                Carbon::now()->subMonths(6)->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])
            ->where('id_status', 1)
            ->orderBy('data_vencimento')
            ->get(['valor', 'tipo', 'data_vencimento']);

        $sql_saldo_anterior = "SELECT valor,tipo From lancamentos
                                WHERE id_usuario=$user_id
                                AND data_vencimento < '".date("Y-m-d",mktime(0,0,0,date('m')-6,1))."'
                                AND id_status=1";
        $lancamentos_saldo_anterior = DB::select($sql_saldo_anterior);


        $for_cli = Fonecedor_cliente::select('nome','id_for_cli')->where('id_usuario', $user_id)->orderBy('nome')->get();
        $agenda = Agenda::where('id_usuario', $user_id)->get();
        $tarefas = Projeto::where('status', '4')->where('id_usuario', $user_id)->get();

        return view('index',['tarefas' => $tarefas,'lancamentos_saldo_anterior' => $lancamentos_saldo_anterior,'agenda' => $agenda,'lancamentos' => $lancamentos,'lancamentos_semestral' => $lancamentos_semestral,'for_cli' => $for_cli]);
    }
 
    public function finalizar_primeiro_acesso(Request $request){
        $user_id = auth()->user()->id;
        if($user_id){
            $sql_primeiro_acesso = "UPDATE users
                            SET primeiro_acesso = 1
                            WHERE id=$user_id ";
            $sql_primeiro_acesso = DB::select($sql_primeiro_acesso);
            
            $status['status']=true;
        }else{
            $status['status']=false;
        }
        echo json_encode($status);
    }

    public function conta(){
        $user_id = auth()->user()->id;
        if($user_id){
            return view('conta');
        }else{
            return view('login');
        }
    }

    public function altera_conta(Request $request){
        $nome = $request->nome_conta;
        $email = $request->email_conta;
        $user_id = auth()->user()->id;
        if($user_id!='' && $nome!='' && $email!=""){
            $sql = "UPDATE users
                    SET name = '$nome',
                        email= '$email'
                    WHERE id=$user_id ";
            $sql = DB::select($sql);
            $status['status']=true;
        }else{
            $status['status']=false;
        }
        echo json_encode($status);
    }

    public function alterar_senha(Request $request){
        $senha_atual = $request->senha_atual;
        $nova_senha = $request->nova_senha;
        $confimar_senha = $request->confimar_senha;
        $user_id = auth()->user()->id;
        if($senha_atual!='' || $nova_senha!='' || $confimar_senha!='' || $confimar_senha===$nova_senha || $user_id!=''){
           
            $user = User::where('id', $user_id)->first();

            if ($user && Hash::check($senha_atual, $user->password)){
                    $nova_senha=Hash::make($nova_senha);
                    $sql = "UPDATE users
                            SET password = '$nova_senha'
                            WHERE id=$user_id";
                    $sql = DB::select($sql);
                    $status['status']=true;
            }else{
                $status['status']=false;
                $status['msg']='Senha errada, tente novamente.';
            }
        }else{
            $status['msg']='Erro.';
            $status['status']=false;
        }
        echo json_encode($status);
    }

    public function buscacep(Request $request){
        $user_id = auth()->user()->id;
        $cep = $request->cep;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://viacep.com.br/ws/$cep/json/",// your preferred link
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
            ),
        ));
        $status['status'] = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        echo json_encode($status);

    }
    
    function del_conta_usuario(Request $request){
        $user_id = auth()->user()->id;
        $deletar_senha = $request->deletar_senha;
        if($user_id && $deletar_senha){
            $user = User::where('id', $user_id)->first();
            if ($user && Hash::check($deletar_senha, $user->password)){
                $email = auth()->user()->email;
                $email =date("Y-m-d h:i:s").'del102030'. $email;
                $user=auth()->user();
                auth()->guard('web')->logout();
                $sql = "UPDATE users
                        SET email = '$email'
                        WHERE id=$user_id ";
                $sql = DB::select($sql);
                
                $status['status']=true;
            }else{
                $status['status']=false;
                $status['msg']='Senha errada, tente novamente.';
            }

           
        }else{
            $status['status']=false;
            $status['msg']='Erro.';
            
        }
        echo json_encode($status);
    }
}
