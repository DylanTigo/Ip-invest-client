<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminInfoSupp extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $projet, $data;

    public function __construct(Array $projet, Array $data)
    {
        $this->projet = $projet;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(auth()->user()->email, auth()->user()->nom_complet . ' - Administrateur chez IP Investment SA')->view('emails.infosupp')
                    ->subject($this->data['objet']);
    }
}
