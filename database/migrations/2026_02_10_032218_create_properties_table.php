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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('agent_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->nullable()->unique();
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('province', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->string('price_period', 20)->nullable();
            $table->unsignedInteger('bedrooms')->nullable();
            $table->unsignedInteger('bathrooms')->nullable();
            $table->unsignedInteger('floors')->nullable();
            $table->unsignedInteger('carports')->nullable();
            $table->unsignedInteger('garages')->nullable();
            $table->unsignedInteger('land_area')->nullable();
            $table->unsignedInteger('building_area')->nullable();
            $table->string('type', 50)->nullable();
            $table->string('status', 50)->nullable();
            $table->string('certificate', 50)->nullable();
            $table->string('electricity', 20)->nullable();
            $table->string('water_source', 50)->nullable();
            $table->string('furnishing', 30)->nullable();
            $table->string('orientation', 30)->nullable();
            $table->unsignedInteger('year_built')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
