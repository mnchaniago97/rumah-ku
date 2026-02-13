<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyNearby extends Model
{
    use HasFactory;

    protected $table = 'property_nearby';

    protected $fillable = [
        'property_id',
        'label',
        'distance',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
