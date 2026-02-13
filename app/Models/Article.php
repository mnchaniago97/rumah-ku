<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'excerpt',
        'content',
        'image',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Article $article): void {
            if (blank($article->slug) && filled($article->title)) {
                $base = Str::slug($article->title);
                $base = $base !== '' ? $base : Str::random(8);

                $slug = $base;
                $suffix = 1;

                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$base}-{$suffix}";
                    $suffix++;
                }

                $article->slug = $slug;
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}

