<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = auth()->user();

        return view('admin.pages.profile', [
            'title' => 'My Profile',
            'user' => $user,
        ]);
    }
}
