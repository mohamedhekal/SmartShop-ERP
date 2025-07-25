<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'total_amount',
        'subtotal',
        'tax_amount',
        'shipping_amount',
        'discount_amount',
        'coupon_code',
        'payment_method',
        'payment_status',
        'shipping_method',
        'shipping_status',
        'billing_address',
        'shipping_address',
        'notes',
        'tracking_number',
        'estimated_delivery',
        'delivered_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'billing_address' => 'array',
        'shipping_address' => 'array',
        'estimated_delivery' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the invoice for the order.
     */
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    /**
     * Get the shipment for the order.
     */
    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }

    /**
     * Get the payments for the order.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the return for the order.
     */
    public function return(): HasOne
    {
        return $this->hasOne(Return::class);
    }

    /**
     * Check if order is paid
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Check if order is delivered
     */
    public function isDelivered(): bool
    {
        return $this->shipping_status === 'delivered';
    }

    /**
     * Check if order can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed', 'processing']);
    }

    /**
     * Get order status badge color
     */
    public function getStatusColorAttribute(): string
    {
        switch($this->status) {
            case 'pending':
                return 'yellow';
            case 'confirmed':
                return 'blue';
            case 'processing':
                return 'purple';
            case 'shipped':
                return 'indigo';
            case 'delivered':
                return 'green';
            case 'cancelled':
                return 'red';
            case 'refunded':
                return 'gray';
            default:
                return 'gray';
        }
    }

    /**
     * Get payment status badge color
     */
    public function getPaymentStatusColorAttribute(): string
    {
        switch($this->payment_status) {
            case 'pending':
                return 'yellow';
            case 'paid':
                return 'green';
            case 'failed':
                return 'red';
            case 'refunded':
                return 'gray';
            default:
                return 'gray';
        }
    }
} 