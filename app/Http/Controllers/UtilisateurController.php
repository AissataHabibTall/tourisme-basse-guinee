<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class UtilisateurController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Optionnel : autoriser automatiquement que les actions passent par la Gate
        // $this->middleware('can:view-admin-section');
    }

        public function index(Request $request)
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        $query = Utilisateur::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('role', 'like', '%' . $search . '%');
            });
        }

        // Pagination avec 10 éléments par page
        $utilisateurs = $query->latest()->paginate(15);

        return view('utilisateurs.index', compact('utilisateurs'));
    }

    public function create()
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        return view('utilisateurs.create');
    }

    public function store(Request $request)
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email',
            'mot_de_passe' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,utilisateur,guide',
        ]);

        $validated['mot_de_passe'] = Hash::make($validated['mot_de_passe']);

        Utilisateur::create($validated);

        return redirect()->route('admin.utilisateurs.index')->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit($id)
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        $utilisateur = Utilisateur::findOrFail($id);
        return view('utilisateurs.edit', compact('utilisateur'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        $utilisateur = Utilisateur::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email,' . $utilisateur->id,
            'mot_de_passe' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,utilisateur,guide',
        ]);

        if (!empty($validated['mot_de_passe'])) {
            $validated['mot_de_passe'] = Hash::make($validated['mot_de_passe']);
        } else {
            unset($validated['mot_de_passe']);
        }

        $utilisateur->update($validated);

        return redirect()->route('admin.utilisateurs.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy($id)
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        $utilisateur = Utilisateur::findOrFail($id);
        $utilisateur->delete();

        return redirect()->route('admin.utilisateurs.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
