<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// We explicitly import the full paths here
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Engin;
use App\Models\Mission;
use App\Models\Conducteur;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Get User Data using the full Facade path to stop the "Undefined" error
        $currentUserName = \Illuminate\Support\Facades\Auth::check() 
            ? \Illuminate\Support\Facades\Auth::user()->name 
            : 'Utilisateur';
            
        $userInitial = substr($currentUserName, 0, 1);

        // 2. Fetch Stats using Full Model Paths
        $enginsDispo = \App\Models\Engin::where('etat', 'Disponible')->count();
        $enginsEnPanne = \App\Models\Engin::where('etat', 'En Maintenance')->count();
        $missionsToday = \App\Models\Mission::whereDate('date_mission', \Carbon\Carbon::today())->count();
        $totalConducteurs = \App\Models\Conducteur::count();

        // 3. Zone Stats using the Full DB Facade path
        $zones = \App\Models\Mission::whereDate('date_mission', \Carbon\Carbon::today())
            ->select('zone', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('zone')
            ->get();

        // 4. Return view with all variables
        return view('dashboard', [
            'enginsDispo'      => $enginsDispo,
            'enginsEnPanne'    => $enginsEnPanne,
            'missionsToday'    => $missionsToday,
            'totalConducteurs' => $totalConducteurs,
            'zones'            => $zones,
            'currentUserName'  => $currentUserName,
            'userInitial'      => $userInitial,
        ]);
    }
}