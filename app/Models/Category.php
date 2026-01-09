<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'image', 'is_active'];

    protected static function booted()
    {
        static::deleting(function ($category) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
        });
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
}
