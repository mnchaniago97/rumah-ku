<?php

use App\Models\Property;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Property::query()
            ->whereNull('slug')
            ->orWhere('slug', '')
            ->orderBy('id')
            ->chunkById(200, function ($properties): void {
                foreach ($properties as $property) {
                    $base = Str::slug((string) $property->title);
                    $base = $base !== '' ? $base : "property-{$property->id}";

                    $slug = $base;

                    $exists = Property::query()
                        ->where('slug', $slug)
                        ->where('id', '!=', $property->id)
                        ->exists();

                    if ($exists) {
                        $slug = "{$base}-{$property->id}";
                    }

                    $property->slug = $slug;
                    $property->saveQuietly();
                }
            });
    }

    public function down(): void
    {
        // no-op (keep slugs)
    }
};

