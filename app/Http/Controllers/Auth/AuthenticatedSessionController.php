<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Utilisateur;

class AuthenticatedSessionController extends Controller
{
    /**
     * Affiche le formulaire de connexion.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Gère la tentative de connexion de l'utilisateur.
     */
    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'mot_de_passe' => ['required', 'string'],
        ]);

        // Recherche de l'utilisateur par email
        $utilisateur = Utilisateur::where('email', $request->email)->first();

        // Vérification du mot de passe
        if ($utilisateur && Hash::check($request->mot_de_passe, $utilisateur->mot_de_passe)) {
            Auth::login($utilisateur, $request->remember); // Connexion réussie

            // Redirection vers la page welcome après la connexion (remplace 'welcome' si nécessaire)
            return redirect()->route('welcome'); // Remplace 'home' par la route de ton choix
        }

        // Si échec : gestion de l'erreur
        throw ValidationException::withMessages([
            'mot_de_passe' => __('Les informations de connexion sont incorrectes.'), // Erreur liée au mot de passe
        ]);
    }

    /**
     * Déconnecte l'utilisateur.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Déconnecté avec succès.');
    }
}
