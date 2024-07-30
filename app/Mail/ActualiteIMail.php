<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActualiteIMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $projet;
    public $investisseur;

    public function __construct(array $projet, array $investisseur)
    {
        $this->projet = $projet;
        $this->investisseur = $investisseur;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@invest--partners.com', 'IP Investment SA')
            ->view('emails.actualitesinvest')
            ->subject("Nouvelle actualité");
    }
}
