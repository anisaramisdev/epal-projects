<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
    'shift', 
    'zone', 
    'destination',
    'engin_id', 
    'conducteur_id', 
    'date_mission', 
    'description'
];

    // Link to the Engin
    public function engin() {
        return $this->belongsTo(Engin::class, 'engin_id');
    }

    // Link to the Conducteur
    public function conducteur() {
        return $this->belongsTo(Conducteur::class, 'conducteur_id');
    }
}