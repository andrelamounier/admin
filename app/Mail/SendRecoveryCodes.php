<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendRecoveryCodes extends Mailable
{
    use Queueable, SerializesModels;

    public $codes;

    public function __construct($codes)
    {
        $this->codes = $codes;
    }

    public function build()
    {
        return $this->view('emails.recovery_codes',['code'=>$this->codes])
                    ->subject('Recuperação de Senha');
    }
}
