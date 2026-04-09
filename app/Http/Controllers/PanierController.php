<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produit;
use App\Models\Commande;
use App\Models\DetailCommande;

class PanierController extends Controller
{
    // Affiche le panier
    public function index()
    {
        $panier = session()->get('panier', []);
        $panierCount = count($panier);

        return view('client.panier', compact('panier','panierCount'));
    }

    // Ajouter un produit au panier
    public function ajouter($id)
    {
        $produit = Produit::findOrFail($id);
        $panier = session()->get('panier', []);

        if(isset($panier[$id])) {
            $panier[$id]['quantite']++;
        } else {
            $panier[$id] = [
                "name" => $produit->name,
                "prix" => $produit->prix,
                "image" => $produit->image,
                "quantite" => 1
            ];
        }

        session()->put('panier', $panier);
        return redirect()->back()->with('success', 'Produit ajouté au panier avec succès');
    }

    // Supprimer un produit du panier
    public function supprimer($id)
    {
        $panier = session()->get('panier', []);
        if(isset($panier[$id])){
            unset($panier[$id]);
            session()->put('panier', $panier);
        }

        return redirect()->back()->with('success', 'Produit supprimé !');
    }

    // Passer le panier en commande

public function commander(Request $request)
{
    $panier = session()->get('panier', []);

    if (empty($panier)) {
        return redirect()->back()->with('error', 'Votre panier est vide.');
    }

    $user = Auth::user();

    // Création commande
    $commande = Commande::create([
        'user_id' => $user ? $user->id : null,
        'name' => $request->name ?? ($user->name ?? 'Invité'),
        'telephone' => $request->telephone ?? ($user->telephone ?? null),
        'statut' => 'en attente',
    ]);

    // Détails commande
    foreach ($panier as $produit_id => $item) {
        DetailCommande::create([
            'commande_id' => $commande->id,
            'produit_id' => $produit_id,
            'quantite' => $item['quantite'],
            'prix' => $item['prix'],
        ]);
    }

    // Vider panier
    session()->forget('panier');

    // ✅ Numéro admin (FORMAT CORRECT)
    $numero = '2250709089755';

    // Message
    $message = "Nouvelle commande #{$commande->id} reçue !";

    // Lien WhatsApp
    $urlWhatsapp = "https://wa.me/" . $numero . "?text=" . urlencode($message);

    // Redirection vers WhatsApp
    return redirect()->away($urlWhatsapp);
}
}