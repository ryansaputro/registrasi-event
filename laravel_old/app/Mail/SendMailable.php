<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $isi;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($isi)
    {
        $this->isi = $isi;
        // $this->from = $from;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->from);
        // if($this->from == 'event'){
            return $this
                    ->subject('Event Registrasi')
                    ->view('email.event');
        // }
    }
}
