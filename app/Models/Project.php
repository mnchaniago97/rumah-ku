<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'developer_id',
        'user_id',
        'name',
        'slug',
        'logo',
        'images',
        'address',
        'city',
        'province',
        'price_start',
        'price_end',
        'description',
        'brochure',
        'video_url',
        'status',
        'is_published',
        'total_units',
        'available_units',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'price_start' => 'decimal:2',
        'price_end' => 'decimal:2',
        'is_published' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'images' => 'array',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = $project->generateUniqueSlug($project->name);
            }
        });

        static::updating(function ($project) {
            if ($project->isDirty('name') && empty($project->slug)) {
                $project->slug = $project->generateUniqueSlug($project->name);
            }
        });
    }

    /**
     * Generate a unique slug for the project.
     */
    public function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $count = static::where('slug', 'like', $slug . '%')
            ->where('id', '!=', $this->id ?? 0)
            ->count();

        return $count > 0 ? "{$slug}-{$count}" : $slug;
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function developer(): BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'property_project');
    }
}
