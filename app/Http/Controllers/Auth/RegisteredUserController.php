<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            // 'prenom' => ['required', 'string', 'max:255'], // Active si tu as ce champ
            'email' => ['required', 'string', 'email', 'max:255', 'unique:utilisateurs'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Création de l'utilisateur avec 'mot_de_passe' au lieu de 'password'
        $utilisateur = Utilisateur::create([
            'nom' => $request->nom,
            // 'prenom' => $request->prenom, // Active si tu as ce champ
            'email' => $request->email,
            'mot_de_passe' => Hash::make($request->password), // Utilisation de mot_de_passe pour la base de données
        ]);

        event(new Registered($utilisateur));

        Auth::login($utilisateur);

        return redirect()->route('welcome');
    }
}
