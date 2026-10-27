<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of OPD users.
     */
    public function index(Request $request): View
    {
        $query = User::where('role', 'opd');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%");
            });
        }

        $users = $query->withCount('shortUrls')->latest()->paginate(15)->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Store a newly created OPD user.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'department' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', Password::min(8)],
        ], [
            'name.required' => 'Nama operator wajib diisi.',
            'email.required' => 'Alamat email dinas wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email dinas sudah terdaftar dalam sistem.',
            'department.required' => 'Nama OPD wajib diisi.',
            'password.required' => 'Kata sandi akun wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        User::create([
            'name' => $request->input('name'),
            'email' => strtolower($request->input('email')),
            'department' => $request->input('department'),
            'password' => Hash::make($request->input('password')),
            'role' => 'opd',
            'is_active' => true,
        ]);

        return redirect()->route('users.index')->with('success', 'Akun OPD berhasil ditambahkan.');
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'department' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', Password::min(8)],
            'is_active' => ['required', 'boolean'],
        ], [
            'name.required' => 'Nama operator wajib diisi.',
            'email.required' => 'Alamat email dinas wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email dinas sudah terdaftar dalam sistem.',
            'department.required' => 'Nama OPD wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        $data = [
            'name' => $request->input('name'),
            'email' => strtolower($request->input('email')),
            'department' => $request->input('department'),
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Data akun OPD berhasil diperbarui.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->isAdmin()) {
            return back()->withErrors(['error' => 'Akun administrator utama tidak dapat dihapus.']);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Akun OPD berhasil dihapus.');
    }
}
