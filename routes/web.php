<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Frontend\ArticleController as FrontendArticleController;
use App\Http\Controllers\Frontend\AsetLelangBankController;
use App\Http\Controllers\Frontend\AgentController as FrontendAgentController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ForumController;
use App\Http\Controllers\Frontend\PerumahanBaruController;
use App\Http\Controllers\Frontend\JoinController;
use App\Http\Controllers\Frontend\LegalController;
use App\Http\Controllers\Frontend\PricingController;
use App\Http\Controllers\Frontend\ProjectController;
use App\Http\Controllers\Frontend\PropertyInquiryController;
use App\Http\Controllers\Frontend\PropertyController as FrontendPropertyController;
use App\Http\Controllers\Frontend\RumahSubsidiController;
use App\Http\Controllers\Frontend\SewaController;
use App\Http\Controllers\Frontend\CompanyPartnerController;
use App\Http\Controllers\Frontend\ContactController as FrontendContactController;
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

// Developer Projects Routes
Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::post('/projects/{slug}/inquiry', [ProjectController::class, 'inquiry'])->name('projects.inquiry');

// Static Pages
Route::view('/about', 'frontend.pages.about')->name('about');
Route::view('/contact', 'frontend.pages.contact')->name('contact');
Route::post('/contact', [FrontendContactController::class, 'store'])->name('contact.store');
Route::view('/perusahaan/produk-layanan', 'frontend.pages.company.products-services', [
    'title' => 'Produk & Layanan - Rumah IO',
])->name('company.products');
Route::get('/perusahaan/partner', [CompanyPartnerController::class, 'index'])->name('company.partners');
Route::get('/kebijakan-privasi', [LegalController::class, 'show'])->defaults('page', 'kebijakan-privasi')->name('legal.privacy');
Route::get('/syarat-penggunaan', [LegalController::class, 'show'])->defaults('page', 'syarat-penggunaan')->name('legal.terms');
Route::get('/syarat-penggunaan-agen', [LegalController::class, 'show'])->defaults('page', 'syarat-penggunaan-agen')->name('legal.agent-terms');
Route::get('/community-guideline', [LegalController::class, 'show'])->defaults('page', 'community-guideline')->name('legal.community');
Route::get('/rumah-subsidi', [RumahSubsidiController::class, 'index'])->name('rumah-subsidi');
Route::get('/sewa', [SewaController::class, 'index'])->name('sewa');
Route::get('/sewa/{shortcut}', [SewaController::class, 'index'])
    ->whereIn('shortcut', ['rumah', 'apartemen', 'kost', 'villa', 'ruko', 'tanah', 'bulanan', 'tahunan', 'bantuan'])
    ->name('sewa.shortcut');
Route::get('/perumahan-baru', [PerumahanBaruController::class, 'index'])->name('perumahan-baru');
Route::get('/agents', [FrontendAgentController::class, 'index'])->name('agents');
Route::get('/agents/{agent}', [FrontendAgentController::class, 'show'])->name('agents.show');
Route::view('/calculator', 'frontend.pages.calculator')->name('calculator');
Route::view('/kpr', 'frontend.pages.kpr')->name('kpr');
Route::redirect('/kpr/simulasi', '/calculator')->name('kpr.simulasi');
Route::redirect('/kpr/pindah', '/takeover')->name('kpr.pindah');
Route::view('/kpr/subsidi', 'frontend.pages.kpr-subsidi')->name('kpr.subsidi');
Route::view('/kpr/dokumen', 'frontend.pages.kpr-dokumen')->name('kpr.dokumen');
Route::view('/kpr/refinancing', 'frontend.pages.kpr-refinancing')->name('kpr.refinancing');
Route::view('/eligibility', 'frontend.pages.eligibility')->name('eligibility');
Route::view('/advertise', 'frontend.pages.advertise')->name('advertise');

// Legacy underscore slugs (keep query string)
Route::get('/pricing/property_agent', function () {
    $qs = request()->getQueryString();
    return redirect()->to('/pricing/property-agent' . ($qs ? ('?' . $qs) : ''), 301);
});
Route::get('/pricing/in_house_marketing', function () {
    $qs = request()->getQueryString();
    return redirect()->to('/pricing/in-house-marketing' . ($qs ? ('?' . $qs) : ''), 301);
});
Route::get('/pricing/property_owner', function () {
    $qs = request()->getQueryString();
    return redirect()->to('/pricing/property-owner' . ($qs ? ('?' . $qs) : ''), 301);
});

Route::get('/join/property_agent', function () {
    $qs = request()->getQueryString();
    return redirect()->to('/join/property-agent' . ($qs ? ('?' . $qs) : ''), 301);
});
Route::get('/join/in_house_marketing', function () {
    $qs = request()->getQueryString();
    return redirect()->to('/join/in-house-marketing' . ($qs ? ('?' . $qs) : ''), 301);
});
Route::get('/join/property_owner', function () {
    $qs = request()->getQueryString();
    return redirect()->to('/join/property-owner' . ($qs ? ('?' . $qs) : ''), 301);
});

Route::redirect('/pricing', '/pricing/property-agent')->name('pricing');
Route::get('/pricing/{type}', [PricingController::class, 'show'])
    ->whereIn('type', ['property-agent', 'in-house-marketing', 'property-owner', 'developer'])
    ->name('pricing.show');
Route::get('/join/{type}', [JoinController::class, 'show'])
    ->whereIn('type', ['property-agent', 'in-house-marketing', 'property-owner', 'developer'])
    ->name('join.show');
Route::post('/join/{type}', [JoinController::class, 'store'])
    ->whereIn('type', ['property-agent', 'in-house-marketing', 'property-owner', 'developer'])
    ->name('join.store');
Route::get('/tanah-dijual', [\App\Http\Controllers\Frontend\TanahController::class, 'index'])->name('tanah-dijual');
Route::view('/takeover', 'frontend.pages.takeover')->name('takeover');
Route::get('/forum', [ForumController::class, 'index'])->name('forum');
Route::get('/forum/posts', [ForumController::class, 'posts'])->name('forum.posts');
Route::post('/forum/posts', [ForumController::class, 'storePost'])->middleware('auth')->name('forum.posts.store');
Route::delete('/forum/posts/{post}', [ForumController::class, 'destroyPost'])->middleware('auth')->name('forum.posts.destroy');
Route::get('/forum/posts/{post}/comments', [ForumController::class, 'comments'])->name('forum.comments');
Route::post('/forum/posts/{post}/comments', [ForumController::class, 'storeComment'])->middleware('auth')->name('forum.comments.store');
Route::delete('/forum/posts/{post}/comments/{comment}', [ForumController::class, 'destroyComment'])->middleware('auth')->name('forum.comments.destroy');
Route::view('/more', 'frontend.pages.more')->name('more');

// Social Auth Routes
Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])
    ->where('provider', 'google|facebook')
    ->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])
    ->where('provider', 'google|facebook')
    ->name('social.callback');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::view('/login', 'admin.pages.auth.login')->name('login');
    Route::view('/register', 'admin.pages.auth.register')->name('register');

    Route::get('/forgot-password', [PasswordResetController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'edit'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');
});

Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Agent Auth Routes
Route::view('/agent/login', 'agent.pages.auth.login')->name('agent.login');
Route::redirect('/agent/register', '/register')->name('agent.register');
Route::post('/agent/login', [AuthController::class, 'login'])->name('agent.login.store');
Route::post('/agent/register', [AuthController::class, 'register'])->name('agent.register.store');

// Redirects
Route::get('/signin', function () {
    return redirect()->route('login');
})->name('signin');

Route::get('/signup', function () {
    return redirect()->route('register');
})->name('signup');
