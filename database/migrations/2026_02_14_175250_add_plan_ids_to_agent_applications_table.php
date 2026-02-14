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
        Schema::table('agent_applications', function (Blueprint $table) {
            $table->foreignId('requested_plan_id')
                ->nullable()
                ->after('requested_type')
                ->constrained('subscription_plans')
                ->nullOnDelete();

            $table->foreignId('approved_plan_id')
                ->nullable()
                ->after('approved_type')
                ->constrained('subscription_plans')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agent_applications', function (Blueprint $table) {
            $table->dropConstrainedForeignId('requested_plan_id');
            $table->dropConstrainedForeignId('approved_plan_id');
        });
    }
};
