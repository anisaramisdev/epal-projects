<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conducteur extends Model
{
    use HasFactory;

    // These match your terminal response
protected $fillable = ['nom', 'prenom', 'permis_numero', 'specialite'];
}