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
        'original_price',
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
        'is_discounted',
        'approved_at',
        'approved_by',
        'published_at',
        'discounted_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
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
        'is_discounted' => 'boolean',
        'approved_at' => 'datetime',
        'published_at' => 'datetime',
        'discounted_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (Property $property): void {
            // Handle slug generation
            if (filled($property->slug) || blank($property->title)) {
                // Continue with price change detection
            } else {
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
            }

            // Detect price change and mark as discounted
            if ($property->exists && $property->isDirty('price')) {
                $oldPrice = $property->getOriginal('price');
                $newPrice = $property->price;

                // If new price is lower than original, mark as discounted
                if ($oldPrice > 0 && $newPrice < $oldPrice) {
                    // Store original price if not already set
                    if (empty($property->original_price) || $property->original_price > $oldPrice) {
                        $property->original_price = $oldPrice;
                    }
                    $property->is_discounted = true;
                    $property->discounted_at = now();
                }
            }

            // Handle manual discount checkbox
            if ($property->is_discounted && empty($property->discounted_at)) {
                $property->discounted_at = now();
            }
            // If discount is unchecked, clear the discounted_at
            if (!$property->is_discounted && $property->isDirty('is_discounted')) {
                $property->discounted_at = null;
            }
        });
    }

    /**
     * Get the discount percentage
     */
    public function getDiscountPercentage(): ?int
    {
        if (!$this->original_price || !$this->price || $this->original_price <= 0) {
            return null;
        }

        $discount = (($this->original_price - $this->price) / $this->original_price) * 100;
        return round($discount);
    }

    /**
     * Scope to filter only discounted properties
     */
    public function scopeDiscounted($query)
    {
        return $query->where('is_discounted', true);
    }

    /**
     * Scope to filter properties for sale (not for rent)
     */
    public function scopeForSale($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('status')
                ->orWhere('status', '!=', 'disewakan');
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
