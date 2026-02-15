<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'agent_id',
        'user_id',
        'title',
        'slug',
        'description',
        'address',
        'city',
        'province',
        'postal_code',
        'whatsapp_phone',
        'latitude',
        'longitude',
        'price',
        'price_period',
        'bedrooms',
        'bathrooms',
        'floors',
        'carports',
        'garages',
        'land_area',
        'building_area',
        'type',
        'status',
        'certificate',
        'electricity',
        'water_source',
        'furnishing',
        'orientation',
        'year_built',
        'is_featured',
        'is_published',
        'is_approved',
        'approved_at',
        'approved_by',
        'published_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'floors' => 'integer',
        'carports' => 'integer',
        'garages' => 'integer',
        'land_area' => 'integer',
        'building_area' => 'integer',
        'year_built' => 'integer',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (Property $property): void {
            if (filled($property->slug) || blank($property->title)) {
                return;
            }

            $base = Str::slug($property->title);
            $base = $base !== '' ? $base : Str::random(8);

            $slug = $base;
            $suffix = 1;

            while (
                static::where('slug', $slug)
                    ->when($property->exists, fn ($q) => $q->where('id', '!=', $property->id))
                    ->exists()
            ) {
                $slug = "{$base}-{$suffix}";
                $suffix++;
            }

            $property->slug = $slug;
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function listingCategories(): BelongsToMany
    {
        return $this->belongsToMany(PropertyListingCategory::class, 'property_listing_category_property')
            ->withTimestamps();
    }

    public function features(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'property_features');
    }

    public function nearby(): HasMany
    {
        return $this->hasMany(PropertyNearby::class);
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(PropertySpecification::class);
    }

    public function videos(): HasMany
    {
        return $this->hasMany(PropertyVideo::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(PropertyDocument::class);
    }

    public function projects(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'property_project');
    }
}
