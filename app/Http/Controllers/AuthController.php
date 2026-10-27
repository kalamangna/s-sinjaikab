<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\EnikdaGatewayService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(Request $request, EnikdaGatewayService $gateway): RedirectResponse
    {
        $request->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'identifier.required' => 'NIP atau email kedinasan wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $identifier = trim($request->input('identifier'));
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // 1. Coba Autentikasi via Gateway ENIKDA / SIMPEG Sinjai jika format NIP
        if ($gateway->isNip($identifier)) {
            $enikdaUser = $gateway->authenticate($identifier, $password);

            if ($enikdaUser) {
                $user = User::where('nip', $enikdaUser['nip'])->first();

                if (!$user) {
                    $user = User::where('email', $enikdaUser['email'])->first();
                }

                if ($user) {
                    if (!$user->is_active) {
                        return back()->withErrors([
                            'identifier' => 'Akun dinonaktifkan oleh administrator.',
                        ]);
                    }

                    $user->update([
                        'nip' => $enikdaUser['nip'],
                        'name' => $enikdaUser['name'],
                        'department' => $enikdaUser['department'],
                    ]);
                } else {
                    $user = User::create([
                        'nip' => $enikdaUser['nip'],
                        'name' => $enikdaUser['name'],
                        'email' => $enikdaUser['email'],
                        'password' => Hash::make($password),
                        'role' => 'opd',
                        'department' => $enikdaUser['department'],
                        'is_active' => true,
                    ]);
                }

                Auth::login($user, $remember);
                $request->session()->regenerate();

                return redirect()->intended(route('dashboard'));
            }
        }

        // 2. Fallback Autentikasi Akun Lokal (Berdasarkan Email atau NIP)
        $credentialsByEmail = ['email' => strtolower($identifier), 'password' => $password];
        $credentialsByNip = ['nip' => $identifier, 'password' => $password];

        if (Auth::attempt($credentialsByEmail, $remember) || Auth::attempt($credentialsByNip, $remember)) {
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'identifier' => 'Akun dinonaktifkan oleh administrator.',
                ]);
            }

            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'identifier' => 'NIP, email dinas, atau kata sandi yang dimasukkan salah.',
        ])->onlyInput('identifier');
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
