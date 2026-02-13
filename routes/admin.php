<?php

use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PropertyInquiryController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\PropertyImageController;
use App\Http\Controllers\Admin\RumahSubsidiController;
use App\Http\Controllers\Admin\SewaController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,agent'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('properties', PropertyController::class);
    Route::patch('properties/{property}/approve', [PropertyController::class, 'approve'])->name('properties.approve');
    Route::patch('properties/{property}/reject', [PropertyController::class, 'reject'])->name('properties.reject');
    Route::delete('properties/{property}/images/{image}', [PropertyImageController::class, 'destroy'])->name('properties.images.destroy');
    Route::resource('categories', CategoryController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('agents', AgentController::class)->only(['index', 'show']);
    Route::patch('agents/{agent}/approve', [AgentController::class, 'approve'])->name('agents.approve');
    Route::delete('agents/{agent}/reject', [AgentController::class, 'reject'])->name('agents.reject');
    Route::resource('testimonials', TestimonialController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('users', UserController::class);
    Route::resource('property-inquiries', PropertyInquiryController::class)
        ->only(['index', 'show', 'update', 'destroy']);

});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('rumah-subsidi', RumahSubsidiController::class);
    Route::resource('sewa', SewaController::class);

});
