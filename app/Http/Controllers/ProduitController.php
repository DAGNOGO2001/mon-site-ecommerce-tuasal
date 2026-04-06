<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    // Affiche la liste des produits
    public function index()
{
    $produits = Produit::with('categorie')->get();
    $user = auth()->user(); // récupère l'utilisateur connecté

    return view('admin.produit.liste_produit', compact('produits', 'user'));
}

    // ✅ Nouvelle méthode pour le client
    public function indexClient()
    {
        $produits = Produit::with('categorie')->get(); // tu peux filtrer si besoin
        return view('client.accueil', compact('produits')); // ton Blade client
    }

    // Détail produit côté client
    public function showClient($id)
    {
        $produit = Produit::with('categorie')->findOrFail($id);
        return view('client.produit_show', compact('produit')); // crée ce Blade si pas existant
    }

    // Affiche le formulaire de création
    public function create()
    {
        $categories = Categorie::all();
        return view('admin.produit.form_produit', compact('categories'));
    }

    // Stocke un nouveau produit
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'stock' => 'required|integer',
            'categorie_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name','description','prix','stock','categorie_id']);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produits','public');
        }

        Produit::create($data);

        return redirect()->route('liste_produit')->with('success', 'Produit créé avec succès !');
    }

    // Affiche le formulaire d'édition
    public function edit($id)
    {
        $produit = Produit::findOrFail($id);
        $categories = Categorie::all();
        return view('admin.produit.edit_produit', compact('produit','categories'));
    }

    // Met à jour un produit existant
    public function update(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'stock' => 'required|integer',
            'categorie_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,html|max:2048',
        ]);

        $data = $request->only(['name','description','prix','stock','categorie_id']);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($produit->image && Storage::disk('public')->exists($produit->image)) {
                Storage::disk('public')->delete($produit->image);
            }
            $data['image'] = $request->file('image')->store('produits','public');
        }

        $produit->update($data);

        return redirect()->route('liste_produit')->with('success', 'Produit mis à jour avec succès !');
    }

    // Supprime un produit
    public function destroy($id)
    {
        $produit = Produit::findOrFail($id);

        if ($produit->image && Storage::disk('public')->exists($produit->image)) {
            Storage::disk('public')->delete($produit->image);
        }

        $produit->delete();

        return redirect()->route('liste_produit')->with('success', 'Produit supprimé avec succès !');
    }

    // Affiche un produit
    public function show($id)
    {
        $produit = Produit::with('categorie')->findOrFail($id);
        return view('produits.show', compact('produit'));
    }

    public function recherche(Request $request)
{
    $query = $request->q;

    $produits = \App\Models\Produit::where('name','like',"%{$query}%")
                ->orWhere('description','like',"%{$query}%")
                ->get();

    return response()->json($produits);
}


}