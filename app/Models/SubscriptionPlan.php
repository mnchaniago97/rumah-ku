<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    public static function allowedNamesForAgentType(string $agentType): array
    {
        return match ($agentType) {
            AgentApplication::TYPE_PROPERTY_AGENT,
            AgentApplication::TYPE_IN_HOUSE_MARKETING => [
                'Starter' => 'Starter',
                'Pro' => 'Pro',
                'Business' => 'Business',
            ],
            AgentApplication::TYPE_PROPERTY_OWNER => [
                'Starter' => 'Starter',
                'Highlight' => 'Highlight',
                'Premium' => 'Premium',
            ],
            AgentApplication::TYPE_DEVELOPER => [
                'Basic' => 'Basic',
                'Growth' => 'Growth',
                'Custom' => 'Custom',
            ],
            default => self::nameOptions(),
        };
    }

    public static function nameOptions(): array
    {
        return [
            'Starter' => 'Starter',
            'Pro' => 'Pro',
            'Business' => 'Business',
            'Highlight' => 'Highlight',
            'Premium' => 'Premium',
            'Basic' => 'Basic',
            'Growth' => 'Growth',
            'Custom' => 'Custom',
        ];
    }

    public static function subtitleOptions(): array
    {
        return [
            'Mulai' => 'Mulai',
            'Populer' => 'Populer',
            'Maksimal' => 'Maksimal',
        ];
    }

    public static function badgeOptions(): array
    {
        return [
            'Mulai' => 'Mulai',
            'Populer' => 'Populer',
            'Maksimal' => 'Maksimal',
            'Custom' => 'Custom',
        ];
    }

    protected $fillable = [
        'agent_type',
        'name',
        'subtitle',
        'badge',
        'is_highlight',
        'price',
        'period_label',
        'features',
        'access',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_highlight' => 'boolean',
            'is_active' => 'boolean',
            'features' => 'array',
            'access' => 'array',
            'price' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function agentApplicationsRequested(): HasMany
    {
        return $this->hasMany(AgentApplication::class, 'requested_plan_id');
    }

    public function agentApplicationsApproved(): HasMany
    {
        return $this->hasMany(AgentApplication::class, 'approved_plan_id');
    }

    public function formattedPrice(): string
    {
        if ($this->price === null) {
            return 'Hubungi kami';
        }

        if ((int) $this->price <= 0) {
            return 'Gratis';
        }

        return 'Rp ' . number_format((int) $this->price, 0, ',', '.');
    }
}
