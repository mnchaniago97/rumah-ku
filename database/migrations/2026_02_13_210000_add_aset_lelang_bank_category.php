<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $exists = DB::table('property_listing_categories')
            ->where('slug', 'aset-lelang-bank')
            ->exists();

        if (!$exists) {
            DB::table('property_listing_categories')->insert([
                'name' => 'Aset Lelang Bank',
                'slug' => 'aset-lelang-bank',
                'is_active' => true,
                'sort_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('property_listing_categories')
            ->where('slug', 'aset-lelang-bank')
            ->delete();
    }
};

