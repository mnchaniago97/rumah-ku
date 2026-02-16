<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $users = $user ? collect([$user]) : collect();

        return view('agent.pages.user.index', [
            'title' => 'Users',
            'users' => $users,
        ]);
    }

    public function show(User $user): View
    {
        $authUser = Auth::user();
        if (!$authUser || $authUser->id !== $user->id) {
            abort(403);
        }

        return view('agent.pages.user.show', [
            'title' => 'User Detail',
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $authUser = Auth::user();
        if (!$authUser || $authUser->id !== $user->id) {
            abort(403);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'role' => ['nullable', 'in:admin,agent'],
            'password' => ['nullable', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:50'],
            'ktp_full_name' => ['nullable', 'string', 'max:255'],
            'whatsapp_phone' => ['nullable', 'string', 'max:50'],
            'professional_email' => ['nullable', 'email', 'max:255'],
            'domicile_area' => ['nullable', 'string', 'max:255'],
            'agency_brand' => ['nullable', 'string', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:100'],
            'agent_registration_number' => ['nullable', 'string', 'max:100'],
            'experience_years' => ['nullable', 'integer', 'min:0', 'max:80'],
            'specialization_areas' => ['nullable', 'string'],
            'bio' => ['nullable', 'string'],
            'avatar' => ['nullable', 'image', 'max:4096'],
            'timezone' => ['nullable', 'string', 'max:64'],
            'language' => ['nullable', 'string', 'max:10'],
            'theme' => ['nullable', 'string', 'max:10'],
            'notifications_email' => ['nullable', 'boolean'],
            'notifications_sms' => ['nullable', 'boolean'],
        ]);

        unset($data['role']);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'uploads');
            $data['avatar'] = '/storage/' . $path;
        }

        $data['notifications_email'] = $request->boolean('notifications_email');
        $data['notifications_sms'] = $request->boolean('notifications_sms');

        $user->update($data);

        return redirect()
            ->route('agent.users.show', $user)
            ->with('success', 'Profil berhasil diperbarui.');
    }
}


