<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User; // Perhatikan: Jika admin Anda menggunakan model lain (misal: App\Models\Admin), pastikan App\Models\User ini diganti atau model yang benar diimpor dan digunakan oleh provider di config/auth.php

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // PENTING: Jika admin Anda login dengan guard 'admin', Anda perlu mengecek guard 'admin' di sini juga.
        // Jika hanya ada satu jenis user (admin), Anda bisa biarkan Auth::check()
        // Atau lebih spesifik:
        if (Auth::guard('admin')->check()) { // <-- PERUBAHAN: Cek guard 'admin'
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ], [
            'name.required' => 'Username wajib diisi!',
            'password.required' => 'Password wajib diisi!',
        ]);

        $credentials = $request->only('name', 'password');

        // ====== BAGIAN YANG DIGANTI/DILENGKAPI ======
        // Gunakan guard 'admin' untuk mencoba login
        if (Auth::guard('admin')->attempt($credentials)) { 
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }
        // ===========================================

        return back()->withInput($request->only('name'))
                     ->with('error', 'Username atau Password salah!');
    }

    public function logout(Request $request)
    {
        // ====== BAGIAN YANG DIGANTI/DILENGKAPI ======
        // Logout dari guard 'admin'
        Auth::guard('admin')->logout();
        // ===========================================

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', 'Anda telah berhasil logout.');
    }
}