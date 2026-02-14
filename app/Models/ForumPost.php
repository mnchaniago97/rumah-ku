<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    use HasFactory;

    public const CATEGORY_BELI_RUMAH = 'beli_rumah';
    public const CATEGORY_KPR = 'kpr';
    public const CATEGORY_INVESTASI = 'investasi';
    public const CATEGORY_RENOVASI = 'renovasi';

    public const CATEGORIES = [
        self::CATEGORY_BELI_RUMAH,
        self::CATEGORY_KPR,
        self::CATEGORY_INVESTASI,
        self::CATEGORY_RENOVASI,
    ];

    protected $fillable = [
        'user_id',
        'category',
        'title',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(ForumComment::class);
    }
}
