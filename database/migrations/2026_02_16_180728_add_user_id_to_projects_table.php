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
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('developer_id')->constrained()->nullOnDelete();
            $table->string('slug')->nullable()->after('name');
            $table->string('logo')->nullable()->after('slug');
            $table->string('brochure')->nullable()->after('logo');
            $table->string('video_url')->nullable()->after('brochure');
            $table->string('status')->default('active')->after('description');
            $table->boolean('is_published')->default(false)->after('status');
            $table->integer('total_units')->nullable()->after('is_published');
            $table->integer('available_units')->nullable()->after('total_units');
            $table->date('start_date')->nullable()->after('available_units');
            $table->date('end_date')->nullable()->after('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'user_id',
                'slug',
                'logo',
                'brochure',
                'video_url',
                'status',
                'is_published',
                'total_units',
                'available_units',
                'start_date',
                'end_date',
            ]);
        });
    }
};
