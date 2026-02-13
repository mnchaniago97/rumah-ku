<?php

use App\Http\Controllers\Agent\DashboardController;
use App\Http\Controllers\Agent\PropertyController;
use App\Http\Controllers\Agent\UserController;
use App\Http\Controllers\Admin\RumahSubsidiController;
use Illuminate\Support\Facades\Route;

Route::prefix('agent')->name('agent.')->middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('properties', PropertyController::class);
    Route::resource('users', UserController::class)->only(['index', 'show', 'update']);
    Route::resource('rumah-subsidi', RumahSubsidiController::class);
});
