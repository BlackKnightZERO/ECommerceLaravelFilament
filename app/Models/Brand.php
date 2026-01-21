<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'image', 'is_active'];

    protected static function booted()
    {
        static::deleting(function ($brand) {
            if ($brand->image) {
                Storage::disk('public')->delete($brand->image);
            }
        });
    }

    public function scopeActive() {
        return $this->where('is_active', true);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
}
