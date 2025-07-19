<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'total'
    ];

    protected $casts = [
        'price' => 'decimal:3',
        'total' => 'decimal:3',
    ];

    // Boot method to calculate total
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            $item->total = $item->quantity * $item->price;
        });

        static::updating(function ($item) {
            $item->total = $item->quantity * $item->price;
        });
    }

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Helper methods
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 3) . ' OMR';
    }

    public function getFormattedTotalAttribute()
    {
        return number_format($this->total, 3) . ' OMR';
    }
}