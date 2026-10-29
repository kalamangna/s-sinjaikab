<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
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
            return redirect()->route('urls.index');
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
            'identifier.required' => 'NIP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $identifier = trim($request->input('identifier'));
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // 1. Coba Autentikasi via Gateway ENIKDA / SIMPEG Sinjai jika format NIP
        if ($gateway->isNip($identifier)) {
            $enikdaUser = $gateway->authenticate($identifier, $password);

            if ($enikdaUser) {
                $user = User::where('nip', $enikdaUser['nip'])->first();

                if ($user) {
                    if (! $user->is_active) {
                        return back()->withErrors([
                            'identifier' => 'Akun dinonaktifkan oleh administrator.',
                        ]);
                    }

                    $user->update([
                        'name' => $enikdaUser['name'],
                        'department' => $enikdaUser['department'],
                    ]);
                } else {
                    $user = User::create([
                        'nip' => $enikdaUser['nip'],
                        'name' => $enikdaUser['name'],
                        'password' => Hash::make($password),
                        'role' => 'user',
                        'department' => $enikdaUser['department'],
                        'is_active' => true,
                    ]);
                }

                Auth::login($user, $remember);
                $request->session()->regenerate();

                ActivityLog::record('login', 'Pengguna berhasil masuk ke sistem.', $user);

                return redirect()->intended(route('urls.index'));
            }
        }

        // 2. Fallback Autentikasi Akun Lokal (Berdasarkan Username untuk Admin atau NIP)
        $credentialsByUsername = ['username' => strtolower($identifier), 'password' => $password];
        $credentialsByNip = ['nip' => $identifier, 'password' => $password];

        if (Auth::attempt($credentialsByUsername, $remember) || Auth::attempt($credentialsByNip, $remember)) {
            $user = Auth::user();

            if (! $user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'identifier' => 'Akun dinonaktifkan oleh administrator.',
                ]);
            }

            $request->session()->regenerate();

            ActivityLog::record('login', 'Pengguna berhasil masuk ke sistem.', $user);

            return redirect()->intended(route('urls.index'));
        }

        return back()->withErrors([
            'identifier' => 'NIP atau Password salah.',
        ])->onlyInput('identifier');
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request): RedirectResponse
    {
        $user = $request->user();
        if ($user) {
            ActivityLog::record('logout', 'Pengguna keluar dari sistem.', $user);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
