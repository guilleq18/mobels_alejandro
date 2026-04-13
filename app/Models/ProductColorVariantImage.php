<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ProductColorVariantImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_color_variant_id',
        'image_path',
        'alt_text',
        'sort_order',
    ];

    public function colorVariant(): BelongsTo
    {
        return $this->belongsTo(ProductColorVariant::class, 'product_color_variant_id');
    }

    public function getImageUrlAttribute(): string
    {
        if (Str::startsWith($this->image_path, ['data:', 'http://', 'https://', '//'])) {
            return $this->image_path;
        }

        return asset(ltrim($this->image_path, '/'));
    }
}
