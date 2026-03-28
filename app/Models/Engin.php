<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Engin extends Model
{
    use HasFactory;

    // Use the exact names from your terminal check
    protected $fillable = ['code', 'designation', 'etat'];
}