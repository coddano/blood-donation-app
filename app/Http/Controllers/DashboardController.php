<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $donneur = $user->donneur;
        $demandes = $user->demandes()->with(['ville', 'groupeSanguin'])->latest()->get();

        // Statistiques pour les donneurs
        $stats = [];
        if ($donneur) {
            // Logique de compatibilité complète
            $compatibilite = [
                'A+' => ['A+', 'AB+'],
                'A-' => ['A+', 'A-', 'AB+', 'AB-'],
                'B+' => ['B+', 'AB+'],
                'B-' => ['B+', 'B-', 'AB+', 'AB-'],
                'AB+' => ['AB+'],
                'AB-' => ['AB+', 'AB-'],
                'O+' => ['A+', 'B+', 'AB+', 'O+'],
                'O-' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']
            ];

            $groupeDonneur = $donneur->groupeSanguin->nom;
            $groupesCompatibles = $compatibilite[$groupeDonneur] ?? [];

            if (!empty($groupesCompatibles)) {
                $groupesIds = \App\Models\GroupeSanguin::whereIn('nom', $groupesCompatibles)->pluck('id');
                $stats['total_demandes_compatibles'] = Demande::where('ville_id', $donneur->ville_id)
                    ->whereIn('groupe_sanguin_id', $groupesIds)
                    ->where('user_id', '!=', $user->id)
                    ->where('statut', 'en attente')
                    ->count();
            } else {
                $stats['total_demandes_compatibles'] = 0;
            }
        }

        return view('dashboard', compact('user', 'donneur', 'demandes', 'stats'));
    }
}
