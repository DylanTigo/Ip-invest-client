<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InteresseProjetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $projet;
    public $investisseur;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Array $projet, Array $investisseur)
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
        return $this->from('info@invest--partners.com', 'IP Investment SA')->view('emails.interesse-projet')
                    ->subject("Nouvelle investiisseur pour le projet '{$this->projet['intitule']}'");
    }
}
