<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejetMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     *
     */

    public $projet, $admin;

    public function __construct(Array $projet, $admin)
    {
        $this->projet = $projet;
        $this->admin = $admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@invest--partners.com', 'IP Investment SA')->view('emails.rejet')
                    ->cc(Auth()->user()->role == 1 ? $this->projet['secteur_data']['conseiller_data']['email'] : $this->admin['email'])
                    ->cc('info@invest--partners.com')
                    ->subject("Refus de votre projet {$this->projet['intitule']}");
    }
}