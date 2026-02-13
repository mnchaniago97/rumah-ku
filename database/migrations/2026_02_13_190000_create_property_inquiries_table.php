<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_inquiries', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('phone', 30);
            $table->string('intent', 20)->default('buy'); // buy|rent
            $table->json('property_types')->nullable();
            $table->string('location')->nullable();
            $table->decimal('price_min', 16, 2)->nullable();
            $table->decimal('price_max', 16, 2)->nullable();
            $table->boolean('wants_kpr')->default(false);
            $table->text('notes')->nullable();

            $table->string('status', 30)->default('new'); // new|contacted|closed
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('contacted_at')->nullable();

            $table->string('page_url')->nullable();
            $table->string('referrer')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_inquiries');
    }
};

