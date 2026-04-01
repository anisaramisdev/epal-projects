<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\ActivityLog; // Added
use Illuminate\Http\Request;

class MissionController extends Controller
{
 public function index(Request $request)
{
    // Professional approach: Only show missions where the engine is still "En Mission"
    // This removes completed/archived missions from the view instantly
    $query = \App\Models\Mission::with(['engin', 'conducteur'])
        ->whereHas('engin', function($q) {
            $q->where('etat', 'En Mission');
        });

    // Keep your date filter logic
    if ($request->has('filter_date') && $request->filter_date != '') {
        $query->whereDate('date_mission', $request->filter_date);
    }

    $missions = $query->latest()->get();

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
        'destination' => 'required|string|max:255',
        'engin_id' => 'required|exists:engins,id',
        'conducteur_id' => 'required|exists:conducteurs,id',
        'date_mission' => 'required|date',
    ]);

    // PREVENT DUPLICATES: Check if engine is actually still available
    $engin = \App\Models\Engin::findOrFail($request->engin_id);
    if ($engin->etat !== 'Disponible') {
        return back()->with('error', 'Cet engin vient juste d\'être affecté à une autre mission.');
    }

    // 1. Create the Mission
    $mission = Mission::create($request->all());

    // 2. IMPORTANT: Lock the engine so it doesn't show up in the list again
    $engin->update(['etat' => 'En Mission']);

    // Log for traceability
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
        'date_mission' => 'required|date|after_or_equal:today',
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

        // Professional Cleanup: If the mission had an engine, make it available again
        if ($mission->engin_id) {
        \App\Models\Engin::where('id', $mission->engin_id)
            ->update(['etat' => 'Disponible']);
        }

        // LOG ACTION (Admin only)
        ActivityLog::record('Suppression Mission', 'ID:  {$id} - Engin Libéré');

        return redirect()->route('missions.index')->with('success', 'Mission annulée et engin libéré.');
    }

public function complete($id)
{
    $mission = \App\Models\Mission::findOrFail($id);
    
    // 1. Release the engine (This is what triggers the "disappearing" from the list)
    if ($mission->engin_id) {
        \App\Models\Engin::where('id', $mission->engin_id)
            ->update(['etat' => 'Disponible']);
    }

    // 2. Log it professionally
    \App\Models\ActivityLog::record('Mission Terminée', "Mission #{$mission->id} achevée.");

    return redirect()->route('missions.index')->with('success', 'Mission terminée et engin libéré.');
}

}