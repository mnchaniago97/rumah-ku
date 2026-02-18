<?php

use App\Http\Controllers\Agent\DashboardController;
use App\Http\Controllers\Agent\DeveloperInquiryController;
use App\Http\Controllers\Agent\DeveloperProjectController;
use App\Http\Controllers\Agent\DeveloperReportController;
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
    Route::delete('sewa/{property}/images/{image}', [PropertyImageController::class, 'destroy'])->name('sewa.images.destroy');
    Route::resource('users', UserController::class)->only(['index', 'show', 'update']);
    Route::resource('rumah-subsidi', RumahSubsidiController::class)->middleware('agent.feature:rumah_subsidi');
    Route::delete('rumah-subsidi/{property}/images/{image}', [PropertyImageController::class, 'destroy'])->name('rumah-subsidi.images.destroy');
    
    // Developer projects - only for developer agent type
    Route::resource('developer-projects', DeveloperProjectController::class);
    Route::delete('developer-projects/{developer_project}/images/{index}', [DeveloperProjectController::class, 'deleteImage'])->name('developer-projects.images.destroy');
    Route::post('developer-projects/{developer_project}/properties', [DeveloperProjectController::class, 'addProperty'])->name('developer-projects.properties.store');
    Route::delete('developer-projects/{developer_project}/properties/{property_id}', [DeveloperProjectController::class, 'removeProperty'])->name('developer-projects.properties.destroy');
    
    // Developer reports (analytics dashboard) - only for developer agent type
    Route::get('developer-reports', [DeveloperReportController::class, 'index'])->name('developer-reports.index');
    
    // Developer inquiries - only for developer agent type
    Route::resource('developer-inquiries', DeveloperInquiryController::class)->only(['index', 'show', 'destroy']);
    Route::put('developer-inquiries/{id}/status', [DeveloperInquiryController::class, 'updateStatus'])->name('developer-inquiries.update-status');
});
