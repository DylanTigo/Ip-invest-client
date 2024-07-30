<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminClotureI extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $projet;
    public $investisseur;

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
        return $this->from('info@invest--partners.com', 'IP Investment SA')->view('emails.adminclotureI')->subject("Clôture du projet " . $this->projet['intitule']);
    }
}
