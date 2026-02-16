<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::latest()->get();

        return view('admin.pages.user.index', [
            'title' => 'Users',
            'users' => $users,
        ]);
    }

    public function create(): View
    {
        return view('admin.pages.user.create', [
            'title' => 'Create User',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'role' => ['required', 'in:admin,agent,user'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:50'],
            'bio' => ['nullable', 'string'],
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created.');
    }

    public function show(User $user): View
    {
        return view('admin.pages.user.show', [
            'title' => 'User Detail',
            'user' => $user,
        ]);
    }

    public function edit(User $user): View
    {
        return view('admin.pages.user.edit', [
            'title' => 'Edit User',
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'role' => ['nullable', 'in:admin,agent,user'],
            'password' => ['nullable', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:50'],
            'bio' => ['nullable', 'string'],
            'avatar' => ['nullable', 'image', 'max:4096'],
            'timezone' => ['nullable', 'string', 'max:64'],
            'language' => ['nullable', 'string', 'max:10'],
            'theme' => ['nullable', 'string', 'max:10'],
            'notifications_email' => ['nullable', 'boolean'],
            'notifications_sms' => ['nullable', 'boolean'],
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if (!array_key_exists('role', $data)) {
            unset($data['role']);
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'uploads');
            $data['avatar'] = '/storage/' . $path;
        }

        $data['notifications_email'] = $request->boolean('notifications_email');
        $data['notifications_sms'] = $request->boolean('notifications_sms');

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted.');
    }
}
