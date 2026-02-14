<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'about',
        'contact',
        'footer',
        'legal',
    ];

    protected function casts(): array
    {
        return [
            'about' => 'array',
            'contact' => 'array',
            'footer' => 'array',
            'legal' => 'array',
        ];
    }
}
