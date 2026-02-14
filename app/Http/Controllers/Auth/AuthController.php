<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = $request->user();
            if ($user && $user->role === 'agent') {
                return redirect()->route('agent.dashboard');
            }

            if ($user && $user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect('/');
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'fname' => ['required', 'string', 'max:100'],
            'lname' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $name = trim($data['fname'].' '.$data['lname']);

        User::create([
            'name' => $name !== '' ? $name : $data['fname'],
            'email' => $data['email'],
            'role' => 'user',
            'is_active' => true,
            'password' => Hash::make($data['password']),
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Register berhasil. Silakan login.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
