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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 50)->nullable()->after('email');
            $table->string('avatar')->nullable()->after('phone');
            $table->text('bio')->nullable()->after('avatar');
            $table->string('timezone', 64)->nullable()->after('bio');
            $table->string('language', 10)->nullable()->after('timezone');
            $table->string('theme', 10)->nullable()->after('language');
            $table->boolean('notifications_email')->default(true)->after('theme');
            $table->boolean('notifications_sms')->default(false)->after('notifications_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'avatar',
                'bio',
                'timezone',
                'language',
                'theme',
                'notifications_email',
                'notifications_sms',
            ]);
        });
    }
};
