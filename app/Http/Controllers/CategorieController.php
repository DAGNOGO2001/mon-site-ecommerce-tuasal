<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;

class CategorieController extends Controller
{
    // Affiche toutes les catégories
    public function affiche() {
        $categories = Categorie::all();
        return view('admin.categorie.liste_categorie', compact('categories'));
    }
    //
    public function show($id) {
    $categorie = Categorie::with('produit')->findOrFail($id);
    return view('admin.categorie.show', compact('categorie'));
}
    // Affiche le formulaire de création
    public function form() {
        return view('admin.categorie.form_categorie');
    }

    // Sauvegarde la nouvelle catégorie
    public function create(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        Categorie::create($request->all());
        return redirect()->route('liste_categorie')->with('success', 'Catégorie ajoutée !');
    }

    // Affiche le formulaire d'édition
    public function edit($id) {
        $categorie = Categorie::findOrFail($id);
        return view('admin.categorie.edit', compact('categorie'));
    }

    // Met à jour une catégorie
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $categorie = Categorie::findOrFail($id);
        $categorie->update($request->all());

        return redirect()->route('liste_categorie')->with('success', 'Catégorie mise à jour !');
    }

    // Supprime une catégorie
    public function delete($id) {
        $categorie = Categorie::findOrFail($id);
        $categorie->delete();

        return redirect()->route('liste_categorie')->with('success', 'Catégorie supprimée !');
    }
}