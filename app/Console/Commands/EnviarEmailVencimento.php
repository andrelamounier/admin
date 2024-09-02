<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\NotificacoesController;

class EnviarEmailVencimento extends Command
{
    protected $signature = 'email:vencimento';
    protected $description = 'Enviar emails de vencimento';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Executa a função do controller
        $controller = new NotificacoesController();
        $controller->email_vencimento();

        $this->info('Emails de vencimento enviados com sucesso!');
    }
}
