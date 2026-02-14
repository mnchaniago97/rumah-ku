<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgentApplication extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    public const TYPE_PROPERTY_AGENT = 'property-agent';
    public const TYPE_IN_HOUSE_MARKETING = 'in-house-marketing';
    public const TYPE_PROPERTY_OWNER = 'property-owner';
    public const TYPE_DEVELOPER = 'developer';

    protected $fillable = [
        'user_id',
        'requested_type',
        'requested_plan_id',
        'status',
        'name',
        'email',
        'phone',
        'whatsapp_phone',
        'domicile_area',
        'payload',
        'approved_type',
        'approved_plan_id',
        'approved_by',
        'approved_at',
        'rejected_at',
        'admin_note',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    public static function typeOptions(): array
    {
        return [
            self::TYPE_PROPERTY_AGENT => 'Agen Properti',
            self::TYPE_IN_HOUSE_MARKETING => 'In-House Marketing',
            self::TYPE_PROPERTY_OWNER => 'Pemilik Properti',
            self::TYPE_DEVELOPER => 'Developer',
        ];
    }

    public static function slugFromType(string $type): string
    {
        return str_replace('_', '-', $type);
    }

    public static function typeFromSlug(string $slug): ?string
    {
        $type = str_replace('_', '-', $slug);

        return array_key_exists($type, self::typeOptions()) ? $type : null;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function requestedPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'requested_plan_id');
    }

    public function approvedPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'approved_plan_id');
    }
}
