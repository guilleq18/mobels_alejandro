<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
        ];
    }

    public function scopeFeatured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        if (Str::startsWith($this->image, ['http://', 'https://', '//'])) {
            return $this->image;
        }

        return '/'.ltrim($this->image, '/');
    }
}
