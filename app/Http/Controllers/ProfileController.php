<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use App\Models\Utilisateur;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Affiche le formulaire de profil utilisateur.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'utilisateur' => Auth::user(),
        ]);
    }

    /**
     * Met à jour les informations du profil utilisateur.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        /** @var Utilisateur $utilisateur */
        $utilisateur = Auth::user();

        // Mise à jour des champs sauf le mot de passe
        $data = $request->safe()->except('mot_de_passe');
        foreach ($data as $key => $value) {
            $utilisateur->{$key} = $value;
        }

        // Mise à jour du mot de passe si fourni
        if ($request->filled('mot_de_passe')) {
            $utilisateur->mot_de_passe = bcrypt($request->mot_de_passe);
        }

        // Réinitialisation de la vérification de l’email si modifié
        if ($utilisateur->email !== $request->user()->email) {
            $utilisateur->email_verified_at = null;
        }

        $utilisateur->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Met à jour la photo de profil de l'utilisateur.
     */
    public function updatePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => 'nullable|image|max:2048',
        ]);

        /** @var Utilisateur $utilisateur */
        $utilisateur = Auth::user();

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();

            $image->storeAs('photos_profil', $filename, 'public');

            if ($utilisateur->photo && Storage::disk('public')->exists('photos_profil/' . $utilisateur->photo)) {
                Storage::disk('public')->delete('photos_profil/' . $utilisateur->photo);
            }

            $utilisateur->photo = $filename;
            $utilisateur->save();
        }

        return back()->with('success', 'Photo de profil mise à jour.');
    }

    /**
     * Supprime la photo de profil.
     */
    public function deletePhoto(Request $request): RedirectResponse
    {
        /** @var Utilisateur $utilisateur */
        $utilisateur = Auth::user();

        if ($utilisateur->photo && Storage::disk('public')->exists('photos_profil/' . $utilisateur->photo)) {
            Storage::disk('public')->delete('photos_profil/' . $utilisateur->photo);
            $utilisateur->photo = null;
            $utilisateur->save();
        }

        return back()->with('success', 'Photo de profil supprimée.');
    }

    /**
     * Supprime le compte de l'utilisateur.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        /** @var Utilisateur $utilisateur */
        $utilisateur = Auth::user();

        Auth::logout();

        $utilisateur->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Met à jour uniquement le mot de passe de l'utilisateur.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'mot_de_passe_actuel' => ['required'],
            'mot_de_passe' => ['required', 'confirmed', Password::defaults()],
        ], [
            'mot_de_passe_actuel.required' => 'Le mot de passe actuel est requis.',
            'mot_de_passe.required' => 'Le nouveau mot de passe est requis.',
            'mot_de_passe.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        /** @var Utilisateur $utilisateur */
        $utilisateur = Auth::user();

        if (!Hash::check($request->mot_de_passe_actuel, $utilisateur->mot_de_passe)) {
            return back()->withErrors([
                'mot_de_passe_actuel' => 'Le mot de passe actuel est incorrect.',
            ]);
        }

        $utilisateur->mot_de_passe = Hash::make($request->mot_de_passe);
        $utilisateur->save();

        return back()->with('status', 'mot-de-passe-mis-a-jour');
    }
}

