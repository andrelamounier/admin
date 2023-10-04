<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Alerta;
use Illuminate\Support\Facades\Auth;

class Notificacao
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user_id = Auth::id();
        $dataDeHoje = now()->toDateString();

        $dados = Alerta::select('tipo', 'qut', 'lida')
        ->where('id_usuario', $user_id)
        ->whereDate('created_at', $dataDeHoje)
        ->get();

        View::share('alertas', $dados);

        return $next($request);
    }
}