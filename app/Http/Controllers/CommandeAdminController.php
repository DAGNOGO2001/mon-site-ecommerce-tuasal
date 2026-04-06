<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;

class CommandeAdminController extends Controller
{
    // Afficher toutes les commandes côté admin
    public function index()
    {
        $commandes = Commande::with(['details.produit', 'user'])->latest()->get();
        $messagesNonLus = Commande::where('lu', false)->count();

        return view('admin.commandes', compact('commandes', 'messagesNonLus'));
    }

    // Mettre à jour le statut via AJAX
    public function updateStatusAjax(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:en attente,confirmée,livrée'
        ]);

        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande introuvable'
            ], 404);
        }

        $commande->statut = $request->statut;

        // Marquer la commande comme lue pour diminuer le badge
        $commande->lu = true;
        $commande->save();

        $count = Commande::where('lu', false)->count();

        return response()->json([
            'success' => true,
            'message' => 'Statut mis à jour avec succès',
            'statut' => $commande->statut,
            'count' => $count
        ]);
    }

    // Supprimer une commande
    public function supprimer($id)
    {
        $commande = Commande::find($id);

        if (!$commande) {
            return redirect()->back()->with('error', 'Commande introuvable.');
        }

        $commande->delete();

        return redirect()->back()->with('success', 'Commande supprimée avec succès.');
    }

    // Retourne le nombre de commandes non lues pour le badge (AJAX)
    public function nombreCommandesNonLues()
    {
        $count = Commande::where('lu', false)->count();
        return response()->json(['count' => $count]);
    }
}