<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class RoleController extends Controller
{
    // Affiche tous les utilisateurs avec leurs rôles
    public function index()
    {
        $users = User::with('roles')->get(); 
        $roles = Role::all(); 
        return view('admin.liste_client', compact('users', 'roles'));
    }

    // Formulaire pour attribuer des rôles
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all(); // récupère tous les rôles existants
        return view('admin.edit_role', compact('user', 'roles'));
    }

    // Ajoute des rôles sans supprimer les anciens
public function update(Request $request, $id)
{
    $request->validate([
        'roles' => 'array',            // c’est un tableau d’IDs
        'roles.*' => 'exists:roles,id' // vérifie que les IDs existent
    ]);

    $user = User::findOrFail($id);

    // sync met à jour la table pivot : ajoute les rôles cochés et retire les décochés
    $user->roles()->sync($request->roles ?? []);

    return redirect()->route('liste_client')->with('success', 'Rôles mis à jour avec succès.');
}
public function delete($id)
{
    $role = User::findOrFail($id);

    $role->delete();

    return redirect()->back()->with('success','Rôle supprimé avec succès');
}
}