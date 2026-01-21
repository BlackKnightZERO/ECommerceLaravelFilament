<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'images',
        'description',
        'price',
        'is_active',
        'is_featured',
        'in_stock',
        'on_sale'
    ];

    protected $casts = [
        'images' => 'array'
    ];

    protected static function booted()
    {
        static::deleting(function ($product) {
            if ($product->images && is_array($product->images)) {
                foreach ($product->images as $image) {
                    if ($image) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }
        });
    }

    public function scopeActive() {
        return $this->where('is_active', true);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function orderItems() {
        return $this->hasMany(orderItem::class);
    }
}
