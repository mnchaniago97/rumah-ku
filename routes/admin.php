<?php

use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\AgentApplicationController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeveloperProjectController;
use App\Http\Controllers\Admin\ForumCommentController;
use App\Http\Controllers\Admin\ForumPostController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PropertyInquiryController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\PropertyImageController;
use App\Http\Controllers\Admin\RumahSubsidiController;
use App\Http\Controllers\Admin\SewaController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ContactMessageController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,agent'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

    Route::resource('properties', PropertyController::class);
    Route::patch('properties/{property}/approve', [PropertyController::class, 'approve'])->name('properties.approve');
    Route::patch('properties/{property}/reject', [PropertyController::class, 'reject'])->name('properties.reject');
    Route::delete('properties/{property}/images/{image}', [PropertyImageController::class, 'destroy'])->name('properties.images.destroy');
    Route::resource('banners', BannerController::class);
    Route::resource('agents', AgentController::class)->only(['index', 'show']);
    Route::patch('agents/{agent}/approve', [AgentController::class, 'approve'])->name('agents.approve');
    Route::delete('agents/{agent}/reject', [AgentController::class, 'reject'])->name('agents.reject');
    Route::patch('agents/{agent}/plan', [AgentController::class, 'updatePlan'])->name('agents.update-plan');
    Route::resource('testimonials', TestimonialController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('users', UserController::class);
    Route::resource('property-inquiries', PropertyInquiryController::class)
        ->only(['index', 'show', 'update', 'destroy']);

});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('agent-applications', [AgentApplicationController::class, 'index'])->name('agent-applications.index');
    Route::get('agent-applications/{agentApplication}', [AgentApplicationController::class, 'show'])->name('agent-applications.show');
    Route::patch('agent-applications/{agentApplication}/approve', [AgentApplicationController::class, 'approve'])->name('agent-applications.approve');
    Route::patch('agent-applications/{agentApplication}/reject', [AgentApplicationController::class, 'reject'])->name('agent-applications.reject');
    Route::patch('agents/{agent}/type', [AgentController::class, 'updateType'])->name('agents.type');
    Route::patch('agents/{agent}/verify', [AgentController::class, 'verify'])->name('agents.verify');
    Route::patch('agents/{agent}/unverify', [AgentController::class, 'unverify'])->name('agents.unverify');
    Route::resource('subscription-plans', SubscriptionPlanController::class)->except(['show']);

    Route::resource('developer-projects', DeveloperProjectController::class)->except(['create', 'store']);
    Route::post('developer-projects/{developer_project}/toggle-publish', [DeveloperProjectController::class, 'togglePublish'])->name('developer-projects.toggle-publish');

    Route::resource('rumah-subsidi', RumahSubsidiController::class);
    Route::delete('rumah-subsidi/{property}/images/{image}', [PropertyImageController::class, 'destroy'])->name('rumah-subsidi.images.destroy');
    Route::resource('sewa', SewaController::class);
    Route::delete('sewa/{property}/images/{image}', [PropertyImageController::class, 'destroy'])->name('sewa.images.destroy');

    Route::resource('forum-posts', ForumPostController::class);
    Route::resource('forum-comments', ForumCommentController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);

    Route::resource('partners', PartnerController::class)->except(['show']);
    Route::resource('contact-messages', ContactMessageController::class)->only(['index', 'show', 'destroy']);
    Route::patch('contact-messages/{contactMessage}/read', [ContactMessageController::class, 'markRead'])->name('contact-messages.read');
    Route::patch('contact-messages/{contactMessage}/unread', [ContactMessageController::class, 'markUnread'])->name('contact-messages.unread');

    Route::get('site-settings', [SiteSettingController::class, 'edit'])->name('site-settings.edit');
    Route::put('site-settings', [SiteSettingController::class, 'update'])->name('site-settings.update');

});
