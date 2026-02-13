<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('property_listing_categories')) {
            Schema::create('property_listing_categories', function (Blueprint $table): void {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->boolean('is_active')->default(true);
                $table->unsignedInteger('sort_order')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('property_listing_category_property')) {
            Schema::create('property_listing_category_property', function (Blueprint $table): void {
                $table->foreignId('property_id')->constrained()->cascadeOnDelete();
                $table->foreignId('property_listing_category_id')
                    ->constrained('property_listing_categories')
                    ->cascadeOnDelete();
                $table->primary(['property_id', 'property_listing_category_id']);
                $table->timestamps();
            });
        }

        $defaults = [
            ['name' => 'Properti Baru', 'slug' => 'properti-baru', 'is_active' => true, 'sort_order' => 1],
            ['name' => 'Properti Populer', 'slug' => 'properti-populer', 'is_active' => true, 'sort_order' => 2],
            ['name' => 'Rekomendasi', 'slug' => 'rekomendasi', 'is_active' => true, 'sort_order' => 3],
            ['name' => 'Pilihan Kami', 'slug' => 'pilihan-kami', 'is_active' => true, 'sort_order' => 4],
            ['name' => 'Rumah Subsidi', 'slug' => 'rumah-subsidi', 'is_active' => true, 'sort_order' => 5],
        ];

        $existingSlugs = DB::table('property_listing_categories')
            ->whereIn('slug', collect($defaults)->pluck('slug')->all())
            ->pluck('slug')
            ->all();

        $toInsert = collect($defaults)
            ->reject(fn ($row) => in_array($row['slug'], $existingSlugs, true))
            ->map(function ($row) {
                $row['created_at'] = now();
                $row['updated_at'] = now();
                return $row;
            })
            ->values()
            ->all();

        if (count($toInsert) > 0) {
            DB::table('property_listing_categories')->insert($toInsert);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('property_listing_category_property');
        Schema::dropIfExists('property_listing_categories');
    }
};
