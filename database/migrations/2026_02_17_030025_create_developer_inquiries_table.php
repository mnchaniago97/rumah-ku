<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('developer_inquiries', function (Blueprint $table): void {
            $table->id();
            
            // Developer (user) who owns the project
            $table->foreignId('developer_id')->constrained('users')->cascadeOnDelete();
            
            // Project being inquired about
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            
            // Inquiry details
            $table->string('name');
            $table->string('email');
            $table->string('phone', 30);
            $table->string('subject')->nullable();
            $table->text('message');
            
            // Additional info
            $table->string('property_type_interest')->nullable(); // rumah, rumah subsidi, apartemen, dll
            $table->decimal('budget_min', 16, 2)->nullable();
            $table->decimal('budget_max', 16, 2)->nullable();
            $table->string('financing_type')->default('cash'); // cash, kpr, installment
            $table->boolean('wants_site_visit')->default(false);
            $table->date('preferred_visit_date')->nullable();
            
            // Status tracking
            $table->string('status', 30)->default('new'); // new, contacted, qualified, closed, rejected
            $table->text('notes')->nullable(); // Internal notes from developer
            $table->timestamp('contacted_at')->nullable();
            
            // Tracking info
            $table->string('page_url')->nullable();
            $table->string('referrer')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            
            $table->timestamps();
            
            // Indexes for faster queries
            $table->index(['developer_id', 'status']);
            $table->index(['project_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('developer_inquiries');
    }
};
