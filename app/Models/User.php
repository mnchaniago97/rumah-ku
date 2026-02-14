<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'agent_verified_at',
        'role',
        'agent_type',
        'agent_subscription_plan_id',
        'is_active',
        'password',
        'phone',
        'ktp_full_name',
        'whatsapp_phone',
        'professional_email',
        'domicile_area',
        'avatar',
        'google_id',
        'facebook_id',
        'bio',
        'agency_brand',
        'job_title',
        'agent_registration_number',
        'experience_years',
        'specialization_areas',
        'timezone',
        'language',
        'theme',
        'notifications_email',
        'notifications_sms',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'agent_verified_at' => 'datetime',
            'password' => 'hashed',
            'notifications_email' => 'boolean',
            'notifications_sms' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function agentPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'agent_subscription_plan_id');
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function isAgentVerified(): bool
    {
        return $this->agent_verified_at !== null;
    }

    public function agentAccess(): ?array
    {
        return $this->agentPlan?->access;
    }

    public function canAgentFeature(string $feature, bool $default = true): bool
    {
        if (($this->role ?? null) !== 'agent') {
            return false;
        }

        $access = $this->agentAccess();
        if ($access === null) {
            return $default;
        }

        if (array_is_list($access)) {
            return in_array($feature, $access, true);
        }

        if (array_key_exists($feature, $access)) {
            return (bool) $access[$feature];
        }

        return $default;
    }

    protected function whatsappPhone(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                if ($value === null) {
                    return null;
                }

                $digits = preg_replace('/\\D+/', '', (string) $value);
                if ($digits === '') {
                    return null;
                }

                if (str_starts_with($digits, '00')) {
                    $digits = substr($digits, 2);
                }

                if (str_starts_with($digits, '0')) {
                    return '62' . substr($digits, 1);
                }

                if (str_starts_with($digits, '8')) {
                    return '62' . $digits;
                }

                return $digits;
            }
        );
    }
}
