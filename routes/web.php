<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LancamentoController;
use App\Http\Controllers\Centro_custoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\Fonecedor_clienteController;
use App\Http\Controllers\StatuController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\Forma_pagController;
use App\Http\Controllers\NotificacaoController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\MedicaoController;
use Illuminate\Support\Facades\Mail;

Route::view('/termos', 'terms');
Route::view('/resetar_senha', 'resetar_senha')->name('reset_senha');
Route::post('/gerar_codigos', [UserController::class, 'gerarCodigos'])->name('gerar_codigos');
Route::post('/admin/gerar_codigos', [UserController::class, 'gerarCodigos']);
//Route::get('/gerar_codigos', [UserController::class, 'gerarCodigos'])->name('gerar_codigos');
Route::get('/nova_senha', [UserController::class, 'showResetForm'])->name('password.reset');
Route::post('/nova_senha', [UserController::class, 'resetPassword']);

Route::get('/test-email', function () {
    Mail::raw('Teste de envio de e-mail', function ($message) {
        $message->to('0k0n4n@gmail.com')
                ->subject('Teste de E-mail');
    });

    return 'E-mail de teste enviado!';
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'notificacao'
])->group(function () {

    Route::get('/dashboard', function () {
        return redirect('/');
    })->name('dashboard');


    Route::post('/del_conta_usuario', [UserController::class,'del_conta_usuario']);
    Route::post('/buscacep', [UserController::class,'buscacep']);
    Route::get('/', [UserController::class,'index']);
    Route::get('/conta', [UserController::class,'conta']);
    Route::post('/altera_conta', [UserController::class,'altera_conta']);
    Route::post('/alterar_senha', [UserController::class,'alterar_senha']);

    Route::get('/financeiro/contas_receber', [LancamentoController::class,'contas_receber']);
    Route::get('/financeiro/contas_pagar', [LancamentoController::class,'contas_pagar']);
    Route::get('financeiro/baixa_multipla', [LancamentoController::class,'baixa_multipla']);
    Route::post('baixar_multiplo', [LancamentoController::class,'baixar_multiplo']);
    Route::get('/financeiro/contas', [LancamentoController::class,'contas_all']);
    Route::post('/add_conta', [LancamentoController::class,'add']);
    Route::post('/del_conta', [LancamentoController::class,'del']);

    Route::match(['get', 'post'],'/financeiro/consulta_contas_receber', [LancamentoController::class,'consulta_contas_receber']);
    Route::match(['get', 'post'],'/financeiro/consulta_contas_pagar', [LancamentoController::class,'consulta_contas_pagar']);
    Route::match(['get', 'post'],'/financeiro/consulta_centro_custo', [LancamentoController::class,'consulta_centro_custo']);
    Route::match(['get', 'post'],'/financeiro/consulta_fluxo_caixa', [LancamentoController::class,'consulta_fluxo_caixa']);


    Route::get('/financeiro/produto', [ProdutoController::class,'index']);
    Route::post('/add_produto', [ProdutoController::class,'add_produto']);
    Route::post('/buscar_Prod', [ProdutoController::class,'buscar_Prod']);


    Route::get('/financeiro/cadastro_centro_custo', [Centro_custoController::class,'index']);
    Route::post('/add_custo', [Centro_custoController::class,'add_custo']);
    Route::post('/del_custo', [Centro_custoController::class,'del_custo']);
    Route::post('/buscar_cc', [Centro_custoController::class,'buscar_cc']);

    Route::post('/saldo_inicial', [LancamentoController::class,'saldo_inicial']);
    Route::post('/centro_custo', [Centro_custoController::class,'centro_custo']);
    Route::post('/fornecedor_cliente', [Fonecedor_clienteController::class,'fornecedor_cliente']);
    Route::post('/produtos', [ProdutoController::class,'produtos']);
    Route::post('/finalizar_primeiro_acesso', [UserController::class,'finalizar_primeiro_acesso']);
    Route::post('/buscar_fc', [Fonecedor_clienteController::class,'buscar_fc']);

    Route::post('/add_agenda', [AgendaController::class,'add_agenda']);
    Route::post('/del_agenda', [AgendaController::class,'del_agenda']);

    Route::get('/documentos/escrever', [DocumentoController::class,'escrever']);
    Route::post('/documentos/add_escrever', [DocumentoController::class,'add_escrever']);
    Route::get('/documentos/upload', [DocumentoController::class,'upload']);
    Route::post('/documentos/dropzoneStorage', [DocumentoController::class,'dropzoneStorage']);
    Route::get('/documentos/download', [DocumentoController::class,'download']);
    Route::match(['get', 'post'],'/documentos/del_documento', [DocumentoController::class,'del_documento']);
    Route::get('/documentos/editar', [DocumentoController::class,'editar']);
    Route::post('/documentos/editar_documento', [DocumentoController::class,'editar_documento']);
    Route::get('/documentos/dropzoneStorageCliFor', [DocumentoController::class,'dropzoneStorageCliFor']);
    Route::match(['get', 'post'],'/documentos/buscar_documentos', [DocumentoController::class,'buscar_documentos']);
    Route::post('/documentos/edita_documento', [DocumentoController::class,'edita_documento']);


    Route::get('/projetos/cadastros', [ProjetoController::class,'cadastros']);
    Route::get('/projetos/tarefas', [ProjetoController::class,'tarefas']);
    Route::post('/projetos/add', [ProjetoController::class,'add_projeto']);
    Route::post('/projetos/altera_check', [ProjetoController::class,'altera_check']);
    Route::post('/projetos/del_tarefa', [ProjetoController::class,'del_tarefa']);

    Route::get('/fonecedor_cliente/perfil', [Fonecedor_clienteController::class,'perfil']);
    Route::get('/fonecedor_cliente', [Fonecedor_clienteController::class,'index']);
    Route::post('/add_for_cli', [Fonecedor_clienteController::class,'add_for_cli']);


    Route::post('/notificacoes', [NotificacaoController::class,'notificacoes']);
    Route::get('/notificacoes_emails', [NotificacaoController::class,'emails']);
    Route::get('/getmensagem/{id}', [NotificacaoController::class, 'getMensagem']);


    Route::get('/contrato', [ContratoController::class,'contratos']);
    Route::post('/busca_contrato', [ContratoController::class,'busca_contrato']);
    Route::post('/add_contrato', [ContratoController::class,'add_contrato']);
    Route::post('/agenda_contrato', [ContratoController::class,'agenda_contrato']);
    Route::get('/get_agenda_contrato', [ContratoController::class,'get_agenda_contrato']);

    Route::get('/medicao', [MedicaoController::class,'medicao']);
    Route::get('/nova_medicao', [MedicaoController::class,'nova_medicao']);
    Route::post('/salvar_medicao', [MedicaoController::class,'salvar_medicao']);
    Route::post('/del_medicao', [MedicaoController::class,'del_medicao']);







});
