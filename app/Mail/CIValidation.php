<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CIValidation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     *
     */

    public $projet;

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
        return $this->from(auth()->user()->email, auth()->user()->nom_complet . ' - Conseiller en investissement chez IP Investment SA')->view('emails.civalidation')
                    ->subject("Approbation du projet {$this->projet['intitule']} par le conseiller");
    }
}
