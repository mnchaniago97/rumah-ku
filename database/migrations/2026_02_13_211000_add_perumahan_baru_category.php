<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $exists = DB::table('property_listing_categories')
            ->where('slug', 'perumahan-baru')
            ->exists();

        if (!$exists) {
            DB::table('property_listing_categories')->insert([
                'name' => 'Perumahan Baru',
                'slug' => 'perumahan-baru',
                'is_active' => true,
                'sort_order' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('property_listing_categories')
            ->where('slug', 'perumahan-baru')
            ->delete();
    }
};

