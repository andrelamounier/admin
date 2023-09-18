<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AgendaController extends Controller
{
    

        public function add_agenda(Request $request){
            
            $validator = Validator::make($request->all(), [
                'titulo_evento_modal' => 'required',
                'data_evento_modal' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 422);
            }
            if($request->get('hora_evento_modal') && $request->get('hora_evento_modal')!='00:00'){
                $data = $request->get('data_evento_modal').' '.$request->get('hora_evento_modal').':00';
            }else{
                $data = $request->get('data_evento_modal');
            }
            $user_id = auth()->user()->id;
            $id_for_cli = $request->get('for_cli_evento_modal') ?? null;
            
    
            if($request->get('id_evento_modal')){
                $agenda = Agenda::find($request->get('id_evento_modal'));
                if (!$agenda || $agenda->id_usuario != $user_id) {
                    return response()->json(['status' => false, 'message' => 'Evento não encontrado'], 404);
                }
                $agenda->titulo = $request->get('titulo_evento_modal');
                $agenda->data = $data;
                $agenda->descricao =  str_replace(array("\r\n", "\r", "\n"), "<br>",$request->get('desc_evento_modal'));
                $agenda->cor = $request->get('cor_evento_modal');
                $agenda->id_for_cli = $id_for_cli;
                try{
                    $agenda->save();
                }catch (\Exception $e) {
                    return response()->json(['status' => false, 'message' => 'Erro 502, tente novamente mais tarde ou entre em contado com suporte.']);
                }
            }else{
                $agenda = new Agenda();
                $agenda->id_usuario = $user_id;
                $agenda->titulo = $request->get('titulo_evento_modal');
                $agenda->data = $data;
                $agenda->descricao =  str_replace(array("\r\n", "\r", "\n"), "<br>",$request->get('desc_evento_modal'));
                $agenda->cor = $request->get('cor_evento_modal');
                $agenda->id_for_cli = $id_for_cli;
                try{
                    $agenda->save();
                }catch (\Exception $e) {
                    return response()->json(['status' => false, 'message' => 'Erro 501, tente novamente mais tarde ou entre em contado com suporte.']);
                }
            }
    
            return response()->json(['status' => true]);
        }
    
    public function del_agenda(Request $request){
        $id = $request->input('id');
        $user_id = auth()->user()->id;
        $agenda = Agenda::where('id', $id)->where('id_usuario', $user_id)->first();
        if($agenda) {
            $agenda->delete();
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false, 'error' => 'Erro 503, tente novamente mais tarde ou entre em contato com suporte.']);
        }
    }

}
