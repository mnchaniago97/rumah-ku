<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PropertyController as AdminPropertyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Frontend\ArticleController as FrontendArticleController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PropertyController as FrontendPropertyController;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/properties', [FrontendPropertyController::class, 'index'])->name('properties');
Route::get('/property/{permalink}', [FrontendPropertyController::class, 'show'])->name('property.show');
Route::get('/search', [FrontendPropertyController::class, 'search'])->name('search');
Route::get('/articles', [FrontendArticleController::class, 'index'])->name('articles');
Route::get('/articles/{slug}', [FrontendArticleController::class, 'show'])->name('articles.show');

// Static Pages
Route::view('/about', 'frontend.about')->name('about');
Route::view('/contact', 'frontend.contact')->name('contact');
Route::view('/projects', 'frontend.projects')->name('projects');
Route::view('/agents', 'frontend.agents')->name('agents');
Route::view('/calculator', 'frontend.calculator')->name('calculator');
Route::view('/advertise', 'frontend.advertise')->name('advertise');
Route::view('/discounted', 'frontend.discounted')->name('discounted');
Route::view('/takeover', 'frontend.takeover')->name('takeover');
Route::view('/forum', 'frontend.forum')->name('forum');
Route::view('/more', 'frontend.more')->name('more');

// Auth Routes
Route::view('/login', 'admin.pages.auth.login')->name('login');
Route::view('/register', 'admin.pages.auth.register')->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Agent Auth Routes
Route::view('/agent/login', 'agent.pages.auth.login')->name('agent.login');
Route::view('/agent/register', 'agent.pages.auth.register')->name('agent.register');
Route::post('/agent/login', [AuthController::class, 'login'])->name('agent.login.store');
Route::post('/agent/register', [AuthController::class, 'registerAgent'])->name('agent.register.store');

// Redirects
Route::get('/signin', function () {
    return redirect()->route('login');
})->name('signin');

Route::get('/signup', function () {
    return redirect()->route('register');
})->name('signup');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('properties', AdminPropertyController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('users', UserController::class);
});
