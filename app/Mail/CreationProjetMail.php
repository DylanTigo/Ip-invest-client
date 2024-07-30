<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreationProjetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $projet;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Array $projet)
    {
        $this->projet = $projet;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@invest--partners.com', 'IP Investment SA')->view('emails.creation-projet')
                    ->subject("Nouveau projet dans le secteur '{$this->projet['secteur_data']['libelle']}'");
    }
}
