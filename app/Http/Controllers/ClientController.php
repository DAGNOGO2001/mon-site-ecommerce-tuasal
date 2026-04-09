<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Commande;

class ClientController extends Controller
{
    // Page d'accueil du client avec tous les produits
    public function accueil()
    {
        $produits = Produit::with('categorie')->get();
        $categories = Categorie::all();

        $messagesNonLus = Auth::check() 
            ? Commande::where('user_id', Auth::id())
                ->where('statut', 'confirmée')
                ->where('lu', false)
                ->count()
            : 0;

        return view('client.accueil', compact('produits', 'categories', 'messagesNonLus'));
    }

    // Page produit individuel
    public function show($id)
    {
        $produit = Produit::with('categorie')->findOrFail($id);
        return view('client.show_produit', compact('produit'));
    }

    // Tableau de bord client
   public function bord()
{
    $user = auth()->user();

    $produits = Produit::all();
    $categories = Categorie::all();

    // commandes traitées
    $commandes = Commande::where('user_id',$user->id)
                    ->whereIn('statut',['confirmée','livrée'])
                    ->latest()
                    ->get();

    // nombre de commandes traitées pour le badge
    $messagesNonLus = Commande::where('user_id',$user->id)
                        ->whereIn('statut',['confirmée','livrée'])
                        ->count();

    return view('client.bord_client', compact(
        'produits',
        'categories',
        'commandes',
        'messagesNonLus'
    ));
}

    // Liste des produits et catégories côté client
    public function index()
    {
        $categories = Categorie::all();
        $produits = Produit::all();
        return view('client.categorie_client', compact('categories', 'produits'));
    }

    // Produits filtrés par catégorie
    public function produitParCategorie($id)
    {
        $categories = Categorie::all();
        $produits = Produit::where('categorie_id', $id)->get();
        return view('client.categorie_client', compact('categories', 'produits'));
    }

    // Marquer les messages comme lus
    public function marquerMessagesLus()
    {
        $userId = auth()->id();

        Commande::where('user_id', $userId)
            ->where('statut', 'confirmée')
            ->where('lu', false)
            ->update(['lu' => true]);

        return response()->json([
            'success' => true,
            'count' => 0
        ]);
    }

    // Nombre de messages non lus (AJAX pour badge)
    public function nombreMessagesNonLus()
    {
        $userId = auth()->id();
        $count = Commande::where('user_id', $userId)
            ->where('statut', 'confirmée')
            ->where('lu', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    // Liste de toutes les commandes du client
    public function listeCommande()
    {
        $userId = auth()->id();
        $commandes = Commande::where('user_id', $userId)
            ->latest()
            ->get();

        return view('client.liste_commande', compact('commandes'));
    }

    // Liste des commandes non lues
    public function commandesNonLues()
    {
        $userId = auth()->id();
        $commandes = Commande::where('user_id', $userId)
            ->where('statut', 'confirmée')
            ->where('lu', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.commandes_non_lues', compact('commandes'));
    }

    // Récupérer le statut d'une commande et la marquer comme lue
    public function getStatut($id)
    {
        $userId = auth()->id();
        $commande = Commande::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$commande) {
            return response()->json(['error' => 'Commande non trouvée'], 404);
        }

        if (!$commande->lu) {
            $commande->lu = true;
            $commande->save();
        }

        return response()->json(['statut' => $commande->statut]);
    }
    public function messagesNonLus()
{
    $user = auth()->user();

    $count = \App\Models\Commande::where('user_id', $user->id)
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
