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
            // Developer company profile fields
            $table->string('company_name')->nullable()->after('agent_type');
            $table->string('company_logo')->nullable()->after('company_name');
            $table->text('company_address')->nullable()->after('company_logo');
            $table->string('company_phone')->nullable()->after('company_address');
            $table->string('company_email')->nullable()->after('company_phone');
            $table->string('company_website')->nullable()->after('company_email');
            $table->text('company_description')->nullable()->after('company_website');
            $table->string('company_npwp')->nullable()->after('company_description');
            $table->string('company_siup')->nullable()->after('company_npwp');
            $table->string('company_nib')->nullable()->after('company_siup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'company_name',
                'company_logo',
                'company_address',
                'company_phone',
                'company_email',
                'company_website',
                'company_description',
                'company_npwp',
                'company_siup',
                'company_nib',
            ]);
        });
    }
};
