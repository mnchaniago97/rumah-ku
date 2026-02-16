<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'developer_id',
        'user_id',
        'name',
        'slug',
        'logo',
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
    ];

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
