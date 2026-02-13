<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Frontend\ArticleController as FrontendArticleController;
use App\Http\Controllers\Frontend\AsetLelangBankController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PerumahanBaruController;
use App\Http\Controllers\Frontend\PropertyInquiryController;
use App\Http\Controllers\Frontend\PropertyController as FrontendPropertyController;
use App\Http\Controllers\Frontend\RumahSubsidiController;
use App\Http\Controllers\Frontend\SewaController;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/properties', [FrontendPropertyController::class, 'index'])->name('properties');
Route::get('/property/{permalink}', [FrontendPropertyController::class, 'show'])->name('property.show');
Route::get('/search', [FrontendPropertyController::class, 'search'])->name('search');
Route::get('/articles', [FrontendArticleController::class, 'index'])->name('articles');
Route::get('/articles/{slug}', [FrontendArticleController::class, 'show'])->name('articles.show');
Route::get('/aset-lelang-bank', [AsetLelangBankController::class, 'index'])->name('aset-lelang-bank');
Route::post('/carikan-properti', [PropertyInquiryController::class, 'store'])->name('property-inquiries.store');

// Static Pages
Route::view('/about', 'frontend.pages.about')->name('about');
Route::view('/contact', 'frontend.pages.contact')->name('contact');
Route::redirect('/projects', '/perumahan-baru')->name('projects');
Route::get('/rumah-subsidi', [RumahSubsidiController::class, 'index'])->name('rumah-subsidi');
Route::get('/sewa', [SewaController::class, 'index'])->name('sewa');
Route::get('/perumahan-baru', [PerumahanBaruController::class, 'index'])->name('perumahan-baru');
Route::view('/agents', 'frontend.pages.agents')->name('agents');
Route::view('/calculator', 'frontend.pages.calculator')->name('calculator');
Route::view('/eligibility', 'frontend.pages.eligibility')->name('eligibility');
Route::view('/advertise', 'frontend.pages.advertise')->name('advertise');
Route::view('/discounted', 'frontend.pages.discounted')->name('discounted');
Route::view('/takeover', 'frontend.pages.takeover')->name('takeover');
Route::view('/forum', 'frontend.pages.forum')->name('forum');
Route::view('/more', 'frontend.pages.more')->name('more');

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
