<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Affiliate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'affiliate_code',
        'commission_rate',
        'total_earnings',
        'paid_earnings',
        'pending_earnings',
        'status',
        'payment_method',
        'payment_details',
        'min_payout',
        'last_payout_at',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'total_earnings' => 'decimal:2',
        'paid_earnings' => 'decimal:2',
        'pending_earnings' => 'decimal:2',
        'min_payout' => 'decimal:2',
        'last_payout_at' => 'datetime',
        'payment_details' => 'array',
    ];

    /**
     * Get the user that owns the affiliate profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the commissions for the affiliate.
     */
    public function commissions(): HasMany
    {
        return $this->hasMany(AffiliateCommission::class);
    }

    /**
     * Get the payouts for the affiliate.
     */
    public function payouts(): HasMany
    {
        return $this->hasMany(AffiliatePayout::class);
    }

    /**
     * Check if affiliate can request payout
     */
    public function canRequestPayout(): bool
    {
        return $this->pending_earnings >= $this->min_payout;
    }

    /**
     * Get available balance for payout
     */
    public function getAvailableBalanceAttribute(): float
    {
        return $this->pending_earnings;
    }

    /**
     * Generate unique affiliate code
     */
    public static function generateAffiliateCode(): string
    {
        do {
            $code = strtoupper(substr(md5(uniqid()), 0, 8));
        } while (self::where('affiliate_code', $code)->exists());

        return $code;
    }
}
