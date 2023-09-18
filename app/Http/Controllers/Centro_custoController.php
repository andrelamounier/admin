<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Centro_custo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class Centro_custoController extends Controller
{
    
    public function index(){
        $user_id = auth()->user()->id;
        if($user_id){
            $centro_custo = Centro_custo::where('id_usuario', $user_id)->orderBy('nome')->get();
            return view ('financeiro/cadastro_centro_custo',['centro_custo' => $centro_custo]);
        }else{
            return redirect('/');
        }
    }
    
    public function add_custo(Request $request){
   
        $validator = Validator::make($request->all(), [
            'nome_centro_custo' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Insira um nome para o centro de custo.']);
        }

        $user_id = auth()->user()->id;
     
        if($request->get('id_centro_custo')){
            try {
                $centro_custo = Centro_custo::where('id_centro_custo', $request->get('id_centro_custo'))->where('id_usuario', $user_id)->firstOrFail();
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Erro 801, tente novamente mais tarde ou entre em contado com suporte.']);
            }
            $centro_custo->nome = $request->get('nome_centro_custo');
            $centro_custo->status = $request->get('ativo_centro_custo') == 'on' ? 1 : 0;
            try{
                $centro_custo->save();
            }catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Erro 802, tente novamente mais tarde ou entre em contado com suporte.']);
            }
        }else{
            $verifica_unico = Centro_custo::where('id_usuario', $user_id )->where('nome', $request->get('centro_custo_nome'))->first();
            if(!$verifica_unico){
                $centro_custo = new Centro_custo;
                $centro_custo->nome = $request->get('nome_centro_custo');
                $centro_custo->status = $request->get('ativo_centro_custo') == 'on' ? 1 : 0;
                $centro_custo->id_usuario = auth()->user()->id;
                try{
                    $centro_custo->save();
                }catch (\Exception $e) {
                    return response()->json(['status' => false, 'message' => 'Erro 803, tente novamente mais tarde ou entre em contado com suporte.']);
                }
            }else{
                return response()->json(['status' => false, 'message' => 'Já existe um Centro de custo com esse nome.']);
            }

        }
        return response()->json(['status' => true]);
    }
    
    
    public function centro_custo(Request $request){
        $user_id = auth()->user()->id;
        if($user_id){
            
            $array= array(
                'Concessionária de Energia'=>$request->energia,
                'Concessionária de Água'=>$request->agua,
                'Ajuste de saldo'=>$request->ajuste,
                'Carro'=>$request->carro,
                'Moradia'=>$request->moradia,
                'Alimentação'=>$request->alimentacao,
                'Telefone/Celular'=>$request->telefone,
                'Educação'=>$request->educacao,
                'Salário'=>$request->salario,
                'Saúde'=>$request->saude,
                'Outros'=>$request->outros
                );
            foreach($array as $k =>$item){
                if($item==1){
                    $centro_custo = new Centro_custo;
                    $centro_custo->id_usuario=$user_id;
                    $centro_custo->nome=$k;
                    $centro_custo->status='1';
                    $centro_custo->save();
                }
            }
            $status['status']= true;
        }else{
            $status['status']=false;
        }
        echo json_encode($status);
    }
    
    public function buscar_cc(){
        $user_id = auth()->user()->id;
        $centro_custo = Centro_custo::where('id_usuario', $user_id)->where('status', 1)->orderBy('nome')->get();
        $status['options'] = '';
        foreach ($centro_custo as $item) {
            $status['options'] .= "<option value='$item->id_centro_custo'>$item->nome</option>";
        }
        $status['status'] = true;
        return response()->json($status);
    }
    
}
