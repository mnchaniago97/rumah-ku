<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('agent_type', 50);
            $table->string('name', 100);
            $table->string('badge', 50)->nullable();
            $table->boolean('is_highlight')->default(false);

            $table->unsignedBigInteger('price')->nullable();
            $table->string('period_label', 50)->nullable();

            $table->json('features')->nullable();
            $table->json('access')->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(['agent_type', 'is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
