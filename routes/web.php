<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EnginController;
use App\Http\Controllers\ConducteurController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// --- 1. COMMON ACCESS (Admins & Agents) ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Viewing Lists (Everyone can see what's in the port)
    Route::get('/engins', [EnginController::class, 'index'])->name('engins.index');
    Route::get('/conducteurs', [ConducteurController::class, 'index'])->name('conducteurs.index');
    Route::get('/missions', [MissionController::class, 'index'])->name('missions.index');
    
    // Mission Operations (Usually Agents are allowed to create missions)
    Route::get('/missions/create', [MissionController::class, 'create'])->name('missions.create');
    Route::post('/missions', [MissionController::class, 'store'])->name('missions.store');
    Route::get('/missions/{id}/print', [MissionController::class, 'show'])->name('missions.print');

    // Profile Settings (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- 2. ADMIN ONLY ACCESS (The "Guard" is active here) ---
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin-panel', [AdminController::class, 'index'])->name('admin.index');
    Route::delete('/admin-panel/user/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::get('/admin-panel/logs', [AdminController::class, 'logs'])->name('admin.logs');
    Route::get('/admin-panel/backup', [AdminController::class, 'backup'])->name('admin.backup');

    // Manage Engins (Create, Edit, Delete)
    Route::get('/engins/create', [EnginController::class, 'create'])->name('engins.create');
    Route::post('/engins', [EnginController::class, 'store'])->name('engins.store');
    Route::get('/engins/{id}/edit', [EnginController::class, 'edit'])->name('engins.edit');
    Route::put('/engins/{id}', [EnginController::class, 'update'])->name('engins.update');
    Route::delete('/engins/{id}', [EnginController::class, 'destroy'])->name('engins.destroy');

    // Manage Conducteurs (Create, Edit, Delete)
    Route::get('/conducteurs/create', [ConducteurController::class, 'create'])->name('conducteurs.create');
    Route::post('/conducteurs', [ConducteurController::class, 'store'])->name('conducteurs.store');
    Route::get('/conducteurs/{id}/edit', [ConducteurController::class, 'edit'])->name('conducteurs.edit');
    Route::put('/conducteurs/{id}', [ConducteurController::class, 'update'])->name('conducteurs.update');
    Route::delete('/conducteurs/{id}', [ConducteurController::class, 'destroy'])->name('conducteurs.destroy');

    // Manage Missions (Edit & Delete missions - Agents can't do this)
    Route::get('/missions/{id}/edit', [MissionController::class, 'edit'])->name('missions.edit');
    Route::put('/missions/{id}', [MissionController::class, 'update'])->name('missions.update');
    Route::delete('/missions/{id}', [MissionController::class, 'destroy'])->name('missions.destroy');
});
Route::get('/missions/{id}/edit', [MissionController::class, 'edit'])->name('missions.edit');
Route::put('/missions/{id}', [MissionController::class, 'update'])->name('missions.update');
Route::patch('/missions/{id}/complete', [MissionController::class, 'complete'])->name('missions.complete');

require __DIR__.'/auth.php';