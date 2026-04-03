<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Engin;
use App\Models\Conducteur;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MissionController extends Controller
{
    // =========================================================
    // INDEX — Show only ACTIVE missions (engine is "En Mission")
    // =========================================================
    public function index(Request $request)
    {
        $query = Mission::with(['engin', 'conducteur'])
            ->whereHas('engin', function ($q) {
                $q->where('etat', 'En Mission');
            });

        // Optional date filter
        if ($request->filled('filter_date')) {
            $query->whereDate('date_mission', $request->filter_date);
        }

        $missions = $query->latest()->get();

        return view('missions.index', compact('missions'));
    }

    // =========================================================
    // CREATE — Show the form (only available engines)
    // =========================================================
    public function create()
    {
        $engins     = Engin::where('etat', 'Disponible')->get();
        $conducteurs = Conducteur::all();

        return view('missions.create', compact('engins', 'conducteurs'));
    }

    // =========================================================
    // STORE — Save a new mission (with all duplicate protections)
    // =========================================================
    public function store(Request $request)
{
    // --- STEP 1: Validate first, before touching the database ---
    $request->validate([
        'engin_id'      => 'required|exists:engins,id',
        'conducteur_id' => 'required|exists:conducteurs,id',
        'destination'   => 'required|string|max:255',
        'date_mission'  => 'required|date|after_or_equal:today|before:2100-01-01',
        'shift'         => 'required',
        'zone'          => 'required',
    ], [
        'date_mission.after_or_equal' => 'La date de mission ne peut pas être dans le passé.',
        'date_mission.before'         => 'La date de mission ne peut pas dépasser l\'an 2099.',
    ]);

    // --- STEP 2: Wrap everything in a transaction with a lock ---
    // DB::transaction() means: if anything fails, nothing is saved.
    // lockForUpdate() means: the database locks this engine row so no
    // other request can read or write it until this block is finished.
    try {
        $mission = DB::transaction(function () use ($request) {

            // Lock this specific engine row in the database.
            // Any other request trying to read this same engine
            // will be forced to WAIT here until we are done.
            $engin = Engin::lockForUpdate()->findOrFail($request->engin_id);

            // Now check availability — only one request at a time can reach this line
            if ($engin->etat !== 'Disponible') {
                throw new \Exception('not_available');
            }
            // Create the mission
            $mission = Mission::create([
                'engin_id'      => $request->engin_id,
                'conducteur_id' => $request->conducteur_id,
                'destination'   => $request->destination,
                'date_mission'  => $request->date_mission,
                'shift'         => $request->shift,
                'zone'          => $request->zone,
                'description'   => $request->description,
            ]);

            // Lock the engine immediately — inside the same transaction
            $engin->update(['etat' => 'En Mission']);

            return $mission;
        });

    } catch (\Exception $e) {
        // If we threw 'not_available', show a friendly message
        // If something else went wrong, show a generic error
        $message = $e->getMessage() === 'not_available'
            ? 'Cet engin vient d\'être affecté. Veuillez en choisir un autre.'
            : 'Une erreur est survenue. Veuillez réessayer.';

        return back()->withInput()->with('error', $message);
    }

    ActivityLog::record('Création Mission', "Mission #{$mission->id} → {$mission->zone} → {$mission->destination}");

    return redirect()->route('missions.index')
        ->with('success', 'Mission lancée avec succès !');
}

    // =========================================================
    // COMPLETE — Mark a mission as done, release the engine
    // =========================================================
    public function complete($id)
    {
        $mission = Mission::with('engin')->findOrFail($id);

        // Release the engine — this is what makes the mission
        // "disappear" from the active list automatically.
        if ($mission->engin) {
            $mission->engin->update(['etat' => 'Disponible']);
        }

        ActivityLog::record('Mission Terminée', "Mission #{$mission->id} → Engin libéré.");

        return redirect()->route('missions.index')
            ->with('success', 'Mission terminée. Engin libéré et disponible.');
    }

    // =========================================================
    // SHOW — Print view
    // =========================================================
    public function show($id)
    {
        $mission = Mission::with(['engin', 'conducteur'])->findOrFail($id);

        return view('missions.print', compact('mission'));
    }

    // =========================================================
    // EDIT — Show the edit form (Admin only)
    // =========================================================
    public function edit($id)
    {
        $mission     = Mission::findOrFail($id);
        $engins      = Engin::all();
        $conducteurs = Conducteur::all();

        return view('missions.edit', compact('mission', 'engins', 'conducteurs'));
    }

    // =========================================================
    // UPDATE — Save edits (Admin only)
    // =========================================================
    public function update(Request $request, $id)
    {
        $mission = Mission::findOrFail($id);

        $request->validate([
            'engin_id'     => 'required|exists:engins,id',
            'conducteur_id' => 'required|exists:conducteurs,id',
            'destination'  => 'required|string|max:255',
            'date_mission' => 'required|date|after_or_equal:today|before:2100-01-01',
            'shift'        => 'required',
            'zone'         => 'required',
        ]);

        $mission->update([
            'engin_id'     => $request->engin_id,
            'conducteur_id' => $request->conducteur_id,
            'destination'  => $request->destination,
            'date_mission' => $request->date_mission,
            'shift'        => $request->shift,
            'zone'         => $request->zone,
            'description'  => $request->description,
        ]);

        ActivityLog::record('Mise à jour Mission', "Mission #{$mission->id} → {$mission->destination}");

        return redirect()->route('missions.index')
            ->with('success', 'Mission mise à jour avec succès !');
    }

    // =========================================================
    // DESTROY — Delete a mission, release the engine (Admin only)
    // =========================================================
    public function destroy($id)
    {
        $mission = Mission::with('engin')->findOrFail($id);

        if ($mission->engin) {
            $mission->engin->update(['etat' => 'Disponible']);
        }

        $mission->delete();

        ActivityLog::record('Suppression Mission', "Mission #{$id} supprimée. Engin libéré.");

        return redirect()->route('missions.index')
            ->with('success', 'Mission annulée et engin libéré.');
    }
}