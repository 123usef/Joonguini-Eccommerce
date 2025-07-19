<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\ImageService;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'category_id',
        'image',
        'slug',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:3',
        'is_active' => 'boolean',
    ];

    
    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    // Image handling methods
    public function getImageUrlAttribute()
    {
        return ImageService::getProductImageUrl($this->image);
    }

    public function getImageThumbnailAttribute()
    {
        return ImageService::getProductImageUrl($this->image);
    }

    public function hasImage()
    {
        return !empty($this->image) && file_exists(public_path('images/' . $this->image));
    }

    // Additional helper methods
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 3) . ' OMR';
    }

    public function isInStock()
    {
        return $this->quantity > 0;
    }

    public function getStockStatusAttribute()
    {
        if ($this->quantity <= 0) {
            return 'Out of Stock';
        } elseif ($this->quantity <= 5) {
            return 'Low Stock';
        } else {
            return 'In Stock';
        }
    }

    public function getStockColorAttribute()
    {
        if ($this->quantity <= 0) {
            return 'danger';
        } elseif ($this->quantity <= 5) {
            return 'warning';
        } else {
            return 'success';
        }
    }
}