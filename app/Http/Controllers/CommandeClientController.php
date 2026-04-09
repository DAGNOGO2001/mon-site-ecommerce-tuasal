<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Mail\ConfirmationCommande;
use App\Mail\NouvelleCommande;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Commande;
use App\Models\DetailCommande;

class CommandeClientController extends Controller
{
    // Afficher la liste des commandes du client
    public function mesCommandes() {
        $userId = auth()->id();
        
        $commandes = Commande::where('user_id', $userId)->latest()->get();

        // Compte toutes les commandes non lues
        $messagesNonLus = Commande::where('user_id', $userId)
            ->where('lu', false)
            ->count();

        return view('client.liste_commande_client', compact('commandes', 'messagesNonLus'));
    }

    // Créer une commande depuis le panier
    public function passerCommande(Request $request)
    {
        $user = Auth::user();
        $panier = session()->get('panier', []);

        if (empty($panier)) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }

        // Créer la commande
        $commande = Commande::create([
            'user_id' => $user->id,
            'name' => $request->name ?? $user->name,
            'telephone' => $request->telephone ?? $user->telephone,
            'statut' => 'en attente', // par défaut
        ]);

        // Créer les détails de la commande
        foreach ($panier as $produit_id => $item) {
            DetailCommande::create([
                'commande_id' => $commande->id,
                'produit_id' => $produit_id,
                'quantite' => $item['quantite'],
                'prix' => $item['prix'], 
            ]);
                }
            // Email admin
        try {
            Mail::to('tchadagnogo@gmail.com')->send(new NouvelleCommande($commande));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        // Email client
        Mail::to(optional($commande->user)->email)
            ->send(new ConfirmationCommande($commande));
session()->forget('panier');


        return redirect()->route('liste_commande')->with('success', 'Votre commande a été passée avec succès !');
    }

    // Supprimer une commande
    public function supprimer($id)
    {
        $commande = Commande::findOrFail($id);
        $commande->delete();

        return redirect()->back()->with('success', 'Commande supprimée avec succès !');
    }

    // Retourne le nombre de commandes non lues pour le badge AJAX
    public function messagesNonLus()
    {
        $userId = auth()->id();
        $count = Commande::where('user_id', $userId)
            ->where('lu', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    public function statutsCommandes()
{
    $userId = auth()->id();

    $commandes = \App\Models\Commande::where('user_id', $userId)
        ->select('id','statut')
        ->get();

    return response()->json($commandes);
}
}