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
        'name',
        'address',
        'city',
        'province',
        'price_start',
        'price_end',
        'description',
    ];

    protected $casts = [
        'price_start' => 'decimal:2',
        'price_end' => 'decimal:2',
    ];

    public function developer(): BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'property_project');
    }
}
