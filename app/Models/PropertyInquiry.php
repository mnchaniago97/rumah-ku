<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'intent',
        'property_types',
        'location',
        'price_min',
        'price_max',
        'wants_kpr',
        'notes',
        'status',
        'handled_by',
        'contacted_at',
        'page_url',
        'referrer',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'property_types' => 'array',
        'price_min' => 'decimal:2',
        'price_max' => 'decimal:2',
        'wants_kpr' => 'boolean',
        'contacted_at' => 'datetime',
    ];

    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}

