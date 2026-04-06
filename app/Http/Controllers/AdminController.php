<?php

namespace App\Http\Controllers;
use App\Mail\StatutCommande;
use Illuminate\Support\Facades\Mail;
use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Tableau de bord admin
    public function index()
    {
        $produits = Produit::all();

        // Nombre de commandes non lues pour le badge
        $messagesNonLus = Commande::where('lu', false)->count();

        return view('admin.bord', compact('produits', 'messagesNonLus'));
    }

    // Liste de toutes les commandes
    public function listeCommandes()
    {
        $commandes = Commande::with(['user', 'details.produit'])
            ->orderBy('created_at', 'desc')
            ->get();

        $messagesNonLus = Commande::where('lu', false)->count();

        return view('admin.commandes', compact('commandes', 'messagesNonLus'));
    }

    // Supprimer une commande
    public function supprimerCommande($id)
    {
        $commande = Commande::findOrFail($id);
        $commande->delete();

        return redirect()->back()->with('success', 'Commande supprimée avec succès.');
    }

    // Changer le statut d'une commande via formulaire classique
// public function changerStatut(Request $request, $id)
// {
//     $commande = Commande::with('user')->findOrFail($id);

//     dd($commande->user); // 👈 ICI

//     $commande->statut = $request->statut;
//     $commande->lu = false;
//     $commande->save();

//     Mail::to($commande->user->email)
//         ->send(new StatutCommande($commande, $request->statut));

//     return back()->with('success', 'Statut mis à jour');
// }
    // Changer le statut via AJAX
  public function changerStatutAjax(Request $request, $id)
{
    $request->validate([
        'statut' => 'required|string|in:en attente,confirmée,livrée'
    ]);

    $commande = Commande::with('user')->findOrFail($id);

    $commande->statut = $request->statut;
    $commande->lu = false;
    $commande->save();

    // ✅ ENVOI EMAIL CLIENT
    if ($commande->user && $commande->user->email) {
        Mail::to($commande->user->email)
            ->send(new StatutCommande($commande, $request->statut));
    }

    return response()->json([
        'success' => true,
        'statut' => $commande->statut
    ]);
}
    // Retourne le nombre de commandes non lues pour le badge (AJAX)
    public function nombreCommandesNonLues()
    {
        $count = Commande::where('lu', false)->count();
        return response()->json(['count' => $count]);
    }

    // ⚡ Optionnel : Marquer une commande comme lue
    public function marquerCommeLue($id)
    {
        $commande = Commande::findOrFail($id);
        $commande->lu = true;
        $commande->save();

        return response()->json(['success' => true]);
    }

// Wathssap
//  public function whatsappCommande($id)
//     {
//         $commande = Commande::with('user')->findOrFail($id);

//         if (!$commande->user || !$commande->user->telephone) {
//             return back()->with('error', 'Numéro introuvable');
//         }

//         $numero = $commande->user->telephone;

//         $message = "Bonjour, votre commande #{$commande->id} est maintenant : {$commande->statut}.";

//         $url = "https://wa.me/{$numero}?text=" . urlencode($message);

//         return redirect()->away($url);
//     }
    
}