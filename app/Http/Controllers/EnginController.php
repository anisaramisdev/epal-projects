<?php

namespace App\Http\Controllers;

use App\Models\Engin;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class EnginController extends Controller
{
    // List all Engins
    public function index()
    {
        $engins = Engin::all();
        return view('engins.index', compact('engins'));
    }

    // Show the Create Form
    public function create()
    {
        return view('engins.create');
    }

    // Save New Engin
    public function store(Request $request)
    {
        // 1. Validate
        $request->validate([
            'nom' => 'required',
            'matricule' => 'required|unique:engins,code',
        ], [
            'matricule.unique' => 'Ce matricule est déjà utilisé par un autre engin.',
        ]);

        // 2. Create and assign to $engin variable so we can use it for the log
        $engin = Engin::create([
            'designation' => $request->nom,
            'code'        => $request->matricule,
            'etat'        => $request->statut,
        ]);

        // 3. Record Log
        ActivityLog::record('Création Engin', $engin->code);

        return redirect()->route('engins.index')->with('success', 'Engin ajouté !');
    }

    // Show Edit Form
    public function edit($id)
    {
        $engin = Engin::findOrFail($id);
        return view('engins.edit', compact('engin'));
    }

    // Update Existing Engin
    public function update(Request $request, $id)
    {
        $engin = Engin::findOrFail($id);

        // 1. Validation
        $request->validate([
            'nom' => 'required|string|max:255',
            'matricule' => 'required|unique:engins,code,' . $id,
        ], [
            'matricule.unique' => 'Désolé, ce matricule (code) est déjà utilisé par un autre engin.',
        ]);

        // 2. Save
        $engin->designation = $request->nom;
        $engin->code        = $request->matricule;
        $engin->etat        = $request->statut;
        $engin->save();

        // 3. Record Log
        ActivityLog::record('Mise à jour Engin', $engin->code);

        return redirect()->route('engins.index')->with('success', 'Engin mis à jour avec succès !');
    }

    // Delete Engin
    public function destroy($id)
    {
        $engin = Engin::findOrFail($id);
        $code = $engin->code; // Save the code before deleting
        $engin->delete();

        // Record Log using the saved code
        ActivityLog::record('Suppression Engin', $code);

        return redirect()->route('engins.index')->with('success', 'Supprimé !');
    }
}