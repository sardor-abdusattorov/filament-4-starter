<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class Settings extends Model
{
    use HasTranslations;

    protected $table = 'settings';

    protected $fillable = ['key', 'value'];

    public $translatable = ['value'];

    protected $casts = [
        'value' => 'array',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();

        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    public static function getOgImage($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $path = settings('seo.og_image')[$locale] ?? '';

        if (! $path) {
            return null;
        }

        if (! str_starts_with($path, 'http')) {
            return asset(Storage::url($path));
        }

        return $path;
    }
}
