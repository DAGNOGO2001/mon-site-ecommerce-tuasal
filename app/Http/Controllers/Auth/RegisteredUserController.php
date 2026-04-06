<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

  public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'telephone' => 'required|numeric|unique:users,telephone',
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // Création de l'utilisateur
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'telephone' => $request->telephone,
        'password' => Hash::make($request->password),
    ]);


        // Crée le rôle 'client' s'il n'existe pas
        $role = Role::firstOrCreate(['name' => 'client']);

        // Associe le rôle à l'utilisateur
        $user->roles()->attach($role->id);

        // Connexion automatique
        Auth::login($user);

        // Redirection selon le rôle
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.bord');
        } elseif ($user->hasRole('client')) {
            return redirect()->route('client_bord');
        }

        return redirect()->route('login');
    }
}