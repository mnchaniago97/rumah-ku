<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('agent_verified_at')->nullable()->after('email_verified_at');
            $table->foreignId('agent_subscription_plan_id')
                ->nullable()
                ->after('agent_type')
                ->constrained('subscription_plans')
                ->nullOnDelete();

            $table->index(['role', 'agent_type', 'agent_verified_at']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role', 'agent_type', 'agent_verified_at']);
            $table->dropConstrainedForeignId('agent_subscription_plan_id');
            $table->dropColumn('agent_verified_at');
        });
    }
};

