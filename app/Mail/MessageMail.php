<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rec;
    public $proj;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $rec, array $proj)
    {
        $this->rec = $rec;
        $this->proj = $proj;  
      
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        // var_dump($this->rec['nom']);
        // dd($this->proj);
        return $this->from($this->rec['email'], 'IP Investment SA')->view('emails.messagemail')
            ->subject("Nouveau message de '{$this->rec['nom']}'");
    }
}
