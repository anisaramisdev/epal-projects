<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // SECURITY: Only an Admin can see the user creation form
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Accès refusé : Seul l\'administrateur peut créer des comptes.');
        }

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // SECURITY: Only an Admin can process a new user registration
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'agent', // New users are always agents by default
        ]);

        event(new Registered($user));

        // IMPORTANT: We REMOVED Auth::login($user) 
        // This keeps YOU (the Admin) logged in while creating the account.

        return redirect(route('admin.index'))->with('success', 'L\'agent a été créé et ajouté à la liste.');
    }
}