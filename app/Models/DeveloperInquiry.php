<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeveloperInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'developer_id',
        'project_id',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'property_type_interest',
        'budget_min',
        'budget_max',
        'financing_type',
        'wants_site_visit',
        'preferred_visit_date',
        'status',
        'notes',
        'contacted_at',
        'page_url',
        'referrer',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
        'wants_site_visit' => 'boolean',
        'preferred_visit_date' => 'date',
        'contacted_at' => 'datetime',
    ];

    /**
     * Get the developer (user) who owns the project.
     */
    public function developer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    /**
     * Get the project being inquired about.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Scope to get inquiries for a specific developer.
     */
    public function scopeForDeveloper($query, $developerId)
    {
        return $query->where('developer_id', $developerId);
    }

    /**
     * Scope to get new inquiries.
     */
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    /**
     * Scope to get contacted inquiries.
     */
    public function scopeContacted($query)
    {
        return $query->where('status', 'contacted');
    }

    /**
     * Get status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'new' => 'Baru',
            'contacted' => 'Dihubungi',
            'qualified' => 'Kualifikasi',
            'closed' => 'Selesai',
            'rejected' => 'Ditolak',
            default => $this->status,
        };
    }

    /**
     * Get status color for badges.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'new' => 'blue',
            'contacted' => 'yellow',
            'qualified' => 'green',
            'closed' => 'gray',
            'rejected' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get financing type label.
     */
    public function getFinancingTypeLabelAttribute(): string
    {
        return match($this->financing_type) {
            'cash' => 'Tunai',
            'kpr' => 'KPR',
            'installment' => 'Cicilan',
            default => $this->financing_type,
        };
    }
}