<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session; 

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard'); 
        }
        
        return view('auth.login'); 
    }


    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];


        if (Auth::attempt($credentials)) {
            // Regenerate session untuk mencegah session fixation attacks
            $request->session()->regenerate();

            // Arahkan ke dashboard admin setelah berhasil login
            return redirect()->route('admin.dashboard');
        } else {
            return back()->withInput($request->only('username'))
                         ->withErrors(['username' => 'Username atau Password yang Anda masukkan salah.']);
        }
    }

    
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login'); 
    }
}