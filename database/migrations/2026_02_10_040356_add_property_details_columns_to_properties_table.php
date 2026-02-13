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
            $table->decimal('latitude', 10, 7)->nullable()->after('postal_code');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->string('price_period', 20)->nullable()->after('price');
            $table->unsignedInteger('floors')->nullable()->after('bathrooms');
            $table->unsignedInteger('carports')->nullable()->after('floors');
            $table->unsignedInteger('garages')->nullable()->after('carports');
            $table->unsignedInteger('land_area')->nullable()->after('garages');
            $table->unsignedInteger('building_area')->nullable()->after('land_area');
            $table->string('certificate', 50)->nullable()->after('status');
            $table->string('electricity', 20)->nullable()->after('certificate');
            $table->string('water_source', 50)->nullable()->after('electricity');
            $table->string('furnishing', 30)->nullable()->after('water_source');
            $table->string('orientation', 30)->nullable()->after('furnishing');
            $table->unsignedInteger('year_built')->nullable()->after('orientation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'latitude',
                'longitude',
                'price_period',
                'floors',
                'carports',
                'garages',
                'land_area',
                'building_area',
                'certificate',
                'electricity',
                'water_source',
                'furnishing',
                'orientation',
                'year_built',
            ]);
        });
    }
};
