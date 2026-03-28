<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    // Matching your migration columns exactly
    protected $fillable = ['user_name', 'action', 'target'];

    /**
     * Static method to record an action
     * Usage: ActivityLog::record('Création', 'Mission #12');
     */
    public static function record($action, $target)
    {
        return self::create([
            'user_name' => Auth::user() ? Auth::user()->name : 'Système',
            'action'    => $action,
            'target'    => $target,
        ]);
    }
}