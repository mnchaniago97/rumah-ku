<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    public const TYPE_BANK = 'bank';
    public const TYPE_DEVELOPER = 'developer';
    public const TYPE_AGENT = 'agent';
    public const TYPE_OTHER = 'other';

    protected $fillable = [
        'type',
        'name',
        'logo',
        'website_url',
        'description',
        'is_kpr',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_kpr' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}

