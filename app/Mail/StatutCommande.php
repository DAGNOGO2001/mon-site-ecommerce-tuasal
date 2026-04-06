<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatutCommande extends Mailable
{
    use Queueable, SerializesModels;

    public $commande;
    public $statut;

    public function __construct($commande, $statut)
    {
        $this->commande = $commande;
        $this->statut = $statut;
    }

    public function build()
    {
        return $this->subject('Mise à jour de votre commande')
                    ->view('emails.statut_commande');
    }
}