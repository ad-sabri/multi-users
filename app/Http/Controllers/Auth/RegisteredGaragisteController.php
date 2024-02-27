<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Garagiste;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredGaragisteController extends Controller
{
    public function create(): View
    {
        return view('auth.register-garagiste');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate();

        return redirect(RouteServiceProvider::HOME);

    }

    public function showGaragisteRegistrationForm(): View
    {
        //dd('hello garagiste');
        return view('auth.register-garagiste');
    }

    public function storeGaragiste(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_garagiste' => true,
        ]);

        //dd($user);

        $garagiste = Garagiste::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'locality' => $request->locality,
            'tva' => $request->tva,
        ]);

        //dd($garagiste);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
