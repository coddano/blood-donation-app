<?php

namespace App\Http\Controllers;

use App\Models\Ville;
use App\Models\Demande;
use App\Models\Donneur;
use Illuminate\Http\Request;
use App\Models\GroupeSanguin;
use Illuminate\Support\Facades\Auth;

class DemandeController extends Controller
{
    public function create()
    {
        $villes = Ville::orderBy('nom')->get();
        $groupeSanguins = GroupeSanguin::all();

        return view('demandes.create', compact('villes', 'groupeSanguins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ville_id' => 'required|exists:villes,id',
            'groupe_sanguin_id' => 'required|exists:groupe_sanguins,id',
            'description' => 'nullable|string|max:255'
        ]);

        $demande = Demande::create([
            'user_id' => Auth::id(),
            'ville_id' => $request->ville_id,
            'groupe_sanguin_id' => $request->groupe_sanguin_id,
            'description' => $request->description,
        ]);

        return redirect()->route('demandes.resultats', $demande)->with('success', 'Votre demande a été créée avec succès ! Voici les donneurs compatibles dans votre ville.');
    }


    public function resultats(Demande $demande)
    {
        // Logique de compatibilité
        $compatibilite = [
            'A+' => ['A+', 'A-', 'O+', 'O-'],
            'A-' => ['A-', 'O-'],
            'B+' => ['B+', 'B-', 'O+', 'O-'],
            'B-' => ['B-', 'O-'],
            'AB+' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
            'AB-' => ['A-', 'B-', 'AB-', 'O-'],
            'O+' => ['O+', 'O-'],
            'O-' => ['O-']
        ];

        $groupeDemandeur = $demande->groupeSanguin->nom;
        $groupeCompatibiliteNoms = $compatibilite[$groupeDemandeur] ?? [];
        $groupeCompatiblesIds = GroupeSanguin::whereIn('nom', $groupeCompatibiliteNoms)->pluck('id');

        $donneurs = Donneur::where('ville_id', $demande->ville_id)
            ->whereIn('groupe_sanguin_id', $groupeCompatiblesIds)
            ->where('disponible', true)
            ->where('user_id', '!=', Auth::id()) // pour ne pas s'afficher soi-même
            ->with('user') // Charger les infos de l'utilisateur
            ->get();

        return view('demandes.resultats', compact('donneurs', 'demande'));
    }
}
