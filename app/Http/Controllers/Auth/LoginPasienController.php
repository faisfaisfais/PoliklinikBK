<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginPasienController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/pasien'; // Sesuaikan dengan rute setelah login

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    // public function showLoginForm()
    // {
    //     return view('auth.pasien-login'); // Buat form login untuk pasien
    // }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required', // NIK atau Nomor RM
        ]);

        $pasien = Pasien::where('nik', $request->identifier)
            ->orWhere('nomorRM', $request->identifier)
            ->first();

        if ($pasien) {
            Auth::guard('pasien')->login($pasien);

            // Redirect ke dashboard pasien
            return redirect()->route('dashboard-pasien');
        }

        return back()->withErrors(['identifier' => 'Invalid credentials.']);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        auth()->guard('pasien')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login-pasien'); // Redirect ke halaman login pasien
    }
}