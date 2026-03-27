<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Halaman form login (input nomor HP)
     */
    public function create()
    {
        return view('auth.login'); 
    }

    /**
     * Kirim OTP ke nomor HP
     */
public function store(Request $request)
{
    $credentials = $request->validate([
        'username' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        $user = Auth::user()->load('level');

        session([
            'school_id' => $user->school_id,
            'profile_photo' => $user->profile_photo,
            'hak_akses' => $user->level->user_level_name ?? 'User'
        ]);
        // ambil school_id user yang login
        session(['school_id' => Auth::user()->school_id]);
 

        return redirect()->route('dashboard');
    }

    return back()->withErrors([
        'username' => 'Username atau password salah.',
    ])->onlyInput('username');
}


    /**
     * Logout
     */
public function destroy(Request $request): RedirectResponse
{
    Auth::logout(); // tidak perlu guard('web') kalau default

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
}
}
