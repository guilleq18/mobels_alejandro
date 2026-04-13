<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'price',
        'stock',
        'lead_time_days',
        'image',
        'is_active',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'lead_time_days' => 'integer',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getVisualAssetAttribute(): string
    {
        return match ($this->slug) {
            'cocina-modular-alba' => 'assets/brand/product-cocina.svg',
            'placard-andes' => 'assets/brand/product-placard.svg',
            'escritorio-nativo' => 'assets/brand/product-escritorio.svg',
            'rack-terra' => 'assets/brand/product-rack.svg',
            default => 'assets/brand/product-default.svg',
        };
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        if (Str::startsWith($this->image, ['http://', 'https://', '//'])) {
            return $this->image;
        }

        return asset(ltrim($this->image, '/'));
    }

    public function getVisualAssetUrlAttribute(): string
    {
        return $this->image_url ?? asset(ltrim($this->visual_asset, '/'));
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $variantImage = $this->colorVariants
            ->flatMap(fn (ProductColorVariant $variant): Collection => $variant->galleryImages)
            ->first();

        if ($variantImage) {
            return $variantImage->image_url;
        }

        return $this->visual_asset_url;
    }

    public function getAvailabilityLabelAttribute(): string
    {
        return 'Disponible en '.max(1, (int) ($this->lead_time_days ?? 7)).' dias';
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function quoteRequests(): HasMany
    {
        return $this->hasMany(QuoteRequest::class);
    }

    public function colorVariants(): HasMany
    {
        return $this->hasMany(ProductColorVariant::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
