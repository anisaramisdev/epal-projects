<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\ActivityLog; // Added
use Illuminate\Http\Request;

class MissionController extends Controller
{
    public function index()
    {
        $missions = Mission::with(['engin', 'conducteur'])->latest()->get();
        return view('missions.index', compact('missions'));
    }

    public function create()
    {
        $engins = \App\Models\Engin::where('etat', 'Disponible')->get();
        $conducteurs = \App\Models\Conducteur::all();
        return view('missions.create', compact('engins', 'conducteurs'));
    }

public function store(Request $request)
{
    $request->validate([
        'shift' => 'required',
        'zone' => 'required',
        'destination' => 'required|string|max:255', // Added
        'engin_id' => 'required|exists:engins,id',
        'conducteur_id' => 'required|exists:conducteurs,id',
        'date_mission' => 'required|date',
    ]);

    $mission = Mission::create($request->all());

    // Log with the destination for better traceability
    ActivityLog::record('Création Mission', "ID: {$mission->id} -> Zone: {$mission->zone} -> Dest: {$mission->destination}");

    return redirect()->route('missions.index')->with('success', 'Mission créée avec succès !');
}

// 1. Show the Edit Form
public function edit($id)
{
    $mission = Mission::findOrFail($id);
    $engins = \App\Models\Engin::all(); // To allow changing the engine
    $conducteurs = \App\Models\Conducteur::all(); // To allow changing the driver
    
    return view('missions.edit', compact('mission', 'engins', 'conducteurs'));
}

// 2. Process the Update
public function update(Request $request, $id)
{
    $mission = Mission::findOrFail($id);

    $request->validate([
        'shift' => 'required',
        'zone' => 'required',
        'destination' => 'required|string|max:255',
        'engin_id' => 'required|exists:engins,id',
        'conducteur_id' => 'required|exists:conducteurs,id',
        'date_mission' => 'required|date',
    ]);

    $mission->update($request->all());

    // Log the update
    \App\Models\ActivityLog::record('Mise à jour Mission', "ID: {$mission->id} - Dest: {$mission->destination}");

    return redirect()->route('missions.index')->with('success', 'Mission mise à jour avec succès !');
}

    // This handles the "Imprimer" part
public function show($id)
{
    // Eager load engin and conducteur to avoid errors on the print page
    $mission = Mission::with(['engin', 'conducteur'])->findOrFail($id);
    
    return view('missions.print', compact('mission'));
}

    public function destroy($id)
    {
        $mission = Mission::findOrFail($id);
        $mission->delete();

        // LOG ACTION (Admin only)
        ActivityLog::record('Suppression Mission', 'ID: ' . $id);

        return redirect()->route('missions.index')->with('success', 'Mission annulée/supprimée.');
    }
}