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
            $table->string('ktp_full_name')->nullable()->after('phone');
            $table->string('whatsapp_phone', 50)->nullable()->after('ktp_full_name');
            $table->string('professional_email')->nullable()->after('whatsapp_phone');
            $table->string('domicile_area')->nullable()->after('professional_email');

            $table->string('agency_brand')->nullable()->after('domicile_area');
            $table->string('job_title', 100)->nullable()->after('agency_brand');
            $table->string('agent_registration_number', 100)->nullable()->after('job_title');
            $table->unsignedTinyInteger('experience_years')->nullable()->after('agent_registration_number');
            $table->text('specialization_areas')->nullable()->after('experience_years');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'ktp_full_name',
                'whatsapp_phone',
                'professional_email',
                'domicile_area',
                'agency_brand',
                'job_title',
                'agent_registration_number',
                'experience_years',
                'specialization_areas',
            ]);
        });
    }
};

