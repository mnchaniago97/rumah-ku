<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'photo',
        'bio',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
