<?php

namespace App\Http\Controllers;

use App\Models\Conducteur;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ConducteurController extends Controller
{
    public function index()
    {
        $conducteurs = Conducteur::all();
        return view('conducteurs.index', compact('conducteurs'));
    }

    public function create()
    {
        return view('conducteurs.create');
    }

    public function store(Request $request)
    {
        // 1. Validation: Added 'specialite', removed 'telephone'
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'permis_numero' => 'required|string|unique:conducteurs,permis_numero',
            'specialite' => 'required|string', 
        ]);

        // 2. Save to Database
        $conducteur = Conducteur::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'permis_numero' => $request->permis_numero,
            'specialite' => $request->specialite,
        ]);

        // 3. Log the action for the Admin Panel
        ActivityLog::record('Nouveau Chauffeur', $conducteur->nom . ' (' . $conducteur->specialite . ')');

        return redirect()->route('conducteurs.index')->with('success', 'Conducteur ajouté avec succès.');
    }

    public function edit($id)
    {
        $conducteur = Conducteur::findOrFail($id);
        return view('conducteurs.edit', compact('conducteur'));
    }

public function update(Request $request, $id)
{
    $conducteur = Conducteur::findOrFail($id);

    $validated = $request->validate([
        'nom' => 'required',
        'prenom' => 'required',
        'permis_numero' => 'required|unique:conducteurs,permis_numero,' . $id,
        'specialite' => 'required',
    ]);

    // Use the update method
    $conducteur->update($validated);

    return redirect()->route('conducteurs.index')->with('success', 'Modifié !');
}

    public function destroy($id)
    {
        $conducteur = Conducteur::findOrFail($id);
        $nomComplet = $conducteur->nom . ' ' . $conducteur->prenom;
        
        $conducteur->delete();

        ActivityLog::record('Suppression Chauffeur', $nomComplet);

        return redirect()->route('conducteurs.index')->with('success', 'Conducteur supprimé.');
    }
}