<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $exists = DB::table('property_listing_categories')->where('slug', 'sewa')->exists();
        
        if (!$exists) {
            $maxOrder = DB::table('property_listing_categories')->max('sort_order') ?? 0;
            
            DB::table('property_listing_categories')->insert([
                'name' => 'Sewa',
                'slug' => 'sewa',
                'is_active' => true,
                'sort_order' => $maxOrder + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('property_listing_categories')->where('slug', 'sewa')->delete();
    }
};
