<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
public function store(LoginRequest $request): RedirectResponse
{
    // Authentifications
    $request->authenticate();

    // Regénère la session pour sécurité
    $request->session()->regenerate();

    // Récupère l'utilisateur connecté
        $user = Auth::user();

        // Redirection selon le rôle
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.bord'); // route admin
        }

        if ($user->hasRole('client')) {
            return redirect()->route('client_bord'); // route client
        }

    // Sinon redirection par défaut
    return redirect()->intended(RouteServiceProvider::HOME);
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
