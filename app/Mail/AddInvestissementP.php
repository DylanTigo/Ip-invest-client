<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AddInvestissementP extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     *
     */

    public $investissement, $admin, $projet;

    public function __construct(Array $investissement, $admin, $projet)
    {
        $this->investissement = $investissement;
        $this->admin = $admin;
        $this->projet = $projet;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@invest--partners.com', 'IP Investment SA')->view('emails.investissementP')
                    ->cc(Auth()->user()->role == 1 ? $this->investissement['user_data']['email'] : $this->admin['email'])
                    ->subject("Nouvelle investissement sur votre projet ". $this->projet['intitule']);
    }
}

