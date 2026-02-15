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
        Schema::table('properties', function (Blueprint $table) {
            $table->decimal('original_price', 15, 2)->nullable()->after('price');
            $table->timestamp('discounted_at')->nullable()->after('original_price');
            $table->boolean('is_discounted')->default(false)->after('discounted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['original_price', 'discounted_at', 'is_discounted']);
        });
    }
};
