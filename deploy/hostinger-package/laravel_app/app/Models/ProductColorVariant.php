<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ProductColorVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'slug',
        'hex_color',
        'swatch_image_path',
        'sort_order',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function galleryImages(): HasMany
    {
        return $this->hasMany(ProductColorVariantImage::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function getBadgeLabelAttribute(): string
    {
        return Str::upper($this->name);
    }

    public function getSwatchImageUrlAttribute(): ?string
    {
        if (! $this->swatch_image_path) {
            return null;
        }

        if (Str::startsWith($this->swatch_image_path, ['data:', 'http://', 'https://', '//'])) {
            return $this->swatch_image_path;
        }

        return '/'.ltrim($this->swatch_image_path, '/');
    }
}
