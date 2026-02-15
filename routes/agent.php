<?php

use App\Http\Controllers\Agent\DashboardController;
use App\Http\Controllers\Agent\PropertyController;
use App\Http\Controllers\Agent\RumahSubsidiController;
use App\Http\Controllers\Agent\SewaController;
use App\Http\Controllers\Agent\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('agent')->name('agent.')->middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Profile - redirect to user show page
    Route::get('/profile', function () {
        return redirect()->route('agent.users.show', auth()->id());
    })->name('profile');

    // Profile edit - redirect to user edit page
    Route::get('/profile/edit', function () {
        return redirect()->route('agent.users.edit', auth()->id());
    })->name('profile.edit');

    Route::resource('properties', PropertyController::class);
    Route::resource('sewa', SewaController::class);
    Route::resource('users', UserController::class)->only(['index', 'show', 'edit', 'update']);
    Route::resource('rumah-subsidi', RumahSubsidiController::class)->middleware('agent.feature:rumah_subsidi');
});
