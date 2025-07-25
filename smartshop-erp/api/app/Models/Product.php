<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'short_description',
        'sku',
        'price',
        'sale_price',
        'cost_price',
        'stock_quantity',
        'min_stock_quantity',
        'weight',
        'dimensions',
        'category_id',
        'brand_id',
        'status',
        'featured',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'featured' => 'boolean',
        'status' => 'string',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the brand that owns the product.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the reviews for the product.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the images for the product.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the tags for the product.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get the wishlist items for the product.
     */
    public function wishlistItems(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Check if product is in stock
     */
    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    /**
     * Check if product is on sale
     */
    public function isOnSale(): bool
    {
        return $this->sale_price && $this->sale_price < $this->price;
    }

    /**
     * Get current price (sale price if available, otherwise regular price)
     */
    public function getCurrentPriceAttribute(): float
    {
        return $this->isOnSale() ? $this->sale_price : $this->price;
    }

    /**
     * Get discount percentage
     */
    public function getDiscountPercentageAttribute(): float
    {
        if (!$this->isOnSale()) {
            return 0;
        }
        return round((($this->price - $this->sale_price) / $this->price) * 100, 2);
    }

    /**
     * Get average rating
     */
    public function getAverageRatingAttribute(): float
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Get reviews count
     */
    public function getReviewsCountAttribute(): int
    {
        return $this->reviews()->count();
    }
}
