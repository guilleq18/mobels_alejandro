<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Throwable;

class StoreSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    protected static ?array $cachedValues = null;

    public static function value(string $key, mixed $default = null): mixed
    {
        $values = static::allValues();

        return $values[$key] ?? $default;
    }

    public static function assetUrl(string $key, ?string $default = null): ?string
    {
        return static::normalizeAssetPath(static::value($key), $default);
    }

    public static function putMany(array $values): void
    {
        foreach ($values as $key => $value) {
            static::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value],
            );
        }

        static::$cachedValues = null;
    }

    public static function normalizeAssetPath(?string $path, ?string $default = null): ?string
    {
        $path = trim((string) ($path ?: $default));

        if ($path === '') {
            return null;
        }

        if (Str::startsWith($path, ['data:', 'http://', 'https://', '//'])) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }

    private static function allValues(): array
    {
        if (static::$cachedValues !== null) {
            return static::$cachedValues;
        }

        try {
            if (! Schema::hasTable('store_settings')) {
                return static::$cachedValues = [];
            }

            return static::$cachedValues = static::query()
                ->pluck('value', 'key')
                ->all();
        } catch (Throwable) {
            return static::$cachedValues = [];
        }
    }
}
