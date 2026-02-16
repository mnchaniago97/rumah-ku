<?php

use App\Http\Controllers\Agent\DashboardController;
use App\Http\Controllers\Agent\DeveloperProjectController;
use App\Http\Controllers\Agent\ProfileController;
use App\Http\Controllers\Agent\PropertyController;
use App\Http\Controllers\Agent\PropertyImageController;
use App\Http\Controllers\Agent\RumahSubsidiController;
use App\Http\Controllers\Agent\SewaController;
use App\Http\Controllers\Agent\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('agent')->name('agent.')->middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile/company', [ProfileController::class, 'updateCompany'])->name('profile.company.update');

    Route::resource('properties', PropertyController::class);
    Route::delete('properties/{property}/images/{image}', [PropertyImageController::class, 'destroy'])->name('properties.images.destroy');
    Route::resource('sewa', SewaController::class);
    Route::resource('users', UserController::class)->only(['index', 'show', 'update']);
    Route::resource('rumah-subsidi', RumahSubsidiController::class)->middleware('agent.feature:rumah_subsidi');
    
    // Developer projects - only for developer agent type
    Route::resource('developer-projects', DeveloperProjectController::class);
});
