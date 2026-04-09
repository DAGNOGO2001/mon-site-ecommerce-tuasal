<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NouvelleCommande extends Mailable
{
    use Queueable, SerializesModels;

    public $commande;

    public function __construct($commande)
    {
        $this->commande = $commande;
    }

    public function build()
    {
        return $this->subject('Nouvelle commande')
                    ->view('emails.nouvelle_commande');
    }
}