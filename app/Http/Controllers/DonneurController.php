<?php

namespace App\Http\Controllers;

use App\Models\Ville;
use App\Models\Donneur;
use Illuminate\Http\Request;
use App\Models\GroupeSanguin;
use Illuminate\Support\Facades\Auth;

class DonneurController extends Controller
{
    public function create()
    {
        $villes = Ville::all();
        $groupeSanguins = GroupeSanguin::all();

        return view('donneurs.create', compact('villes', 'groupeSanguins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ville_id' => 'required|exists:villes,id',
            'groupe_sanguin_id' => 'required|exists:groupe_sanguins,id',
            'telephone' => 'required|string|max:20',
        ]);

        Donneur::create([
            'user_id' => Auth::id(),
            'ville_id' => $request->ville_id,
            'groupe_sanguin_id' => $request->groupe_sanguin_id,
            'telephone' => $request->telephone,
        ]);

        return redirect('/dashboard')->with('success', 'Félicitation, vous faites maintenant partie de nos donneurs !');
    }
}
