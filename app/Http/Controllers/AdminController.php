<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // Get all users so we can display them in the management list
        $users = User::all();
        return view('admin.index', compact('users'));
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        // Safety: Don't let the admin delete themselves!
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();
        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function logs() {
        $logs = \App\Models\ActivityLog::latest()->get();
        return view('admin.logs', compact('logs'));
    }

    public function backup()
{
    // 1. Get all table names
    $tables = DB::select('SHOW TABLES');
    $databaseName = env('DB_DATABASE');
    $property = "Tables_in_" . $databaseName;

    $sqlScript = "-- EPAL DCL Database Backup\n";
    $sqlScript .= "-- Date: " . now()->format('d-m-Y H:i:s') . "\n\n";

    foreach ($tables as $table) {
        $tableName = $table->$property;
        
        // 2. Get the CREATE TABLE statement
        $createText = DB::select("SHOW CREATE TABLE $tableName")[0]->{'Create Table'};
        $sqlScript .= "\n\n" . $createText . ";\n\n";

        // 3. Get the data
        $rows = DB::table($tableName)->get();
        foreach ($rows as $row) {
            $sqlScript .= "INSERT INTO $tableName VALUES (";
            $values = array_values((array)$row);
            $formattedValues = array_map(function($v) {
                return is_null($v) ? "NULL" : "'" . addslashes($v) . "'";
            }, $values);
            $sqlScript .= implode(", ", $formattedValues) . ");\n";
        }
    }

    // 4. Log the action
    \App\Models\ActivityLog::record('Sauvegarde Système', 'Exportation SQL Complète');

    // 5. Download the file
    $fileName = "backup_epal_" . now()->format('Y-m-d_H-i') . ".sql";
    return response($sqlScript)
        ->header('Content-Type', 'application/sql')
        ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
}
}