<?php

use App\Models\Settings;
use App\Models\SiteSettings;
use App\Models\SiteTranslation;
use Illuminate\Support\Facades\Cache;

if (! function_exists('settings')) {
    /**
     * Get or set settings value with caching
     *
     * @param  string  $key  Setting key (e.g., 'seo.title', 'metrics.yandex')
     * @param  mixed  $default  Default value if not found
     * @return mixed
     */
    function settings(string $key, mixed $default = null): mixed
    {
        $cacheKey = "settings.{$key}";

        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = Settings::where('key', $key)->first();

            return $setting ? $setting->value : $default;
        });
    }
}

if (! function_exists('clear_settings_cache')) {
    /**
     * Clear settings cache
     *
     * @param  string|null  $key  Setting key (if null - clear all)
     */
    function clear_settings_cache(?string $key = null): void
    {
        if ($key) {
            Cache::forget("settings.{$key}");
        } else {
            Settings::all()->each(function ($setting) {
                Cache::forget("settings.{$setting->key}");
            });
        }
    }
}

if (! function_exists('site_setting')) {
    /**
     * Get site setting from database with caching
     *
     * @param  string  $key  Setting key
     * @param  mixed  $default  Default value
     * @return mixed
     */
    function site_setting(string $key, mixed $default = null): mixed
    {
        $cacheKey = "site_setting.{$key}";

        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = SiteSettings::query()
                ->where('name', $key)
                ->where('is_published', true)
                ->first();

            return $setting ? $setting->value : $default;
        });
    }
}

if (! function_exists('clear_site_settings_cache')) {
    /**
     * Clear site settings cache
     *
     * @param  string|null  $key  Setting key (if null - clear all)
     */
    function clear_site_settings_cache(?string $key = null): void
    {
        if ($key) {
            Cache::forget("site_setting.{$key}");
        } else {
            SiteSettings::all()->each(function ($setting) {
                Cache::forget("site_setting.{$setting->name}");
            });
        }
    }
}

if (! function_exists('translator')) {
    /**
     * Get translation from database with caching
     *
     * @param  string  $category  Translation category
     * @param  string|null  $key  Translation key
     * @param  array  $replace  Replacements array
     * @param  string|null  $locale  Locale
     * @return string
     */
    function translator($category, $key = null, $replace = [], $locale = null)
    {
        $locale = $locale ?: app()->getLocale();

        if ($key === null && str_contains($category, '.')) {
            [$category, $key] = explode('.', $category, 2);
        }

        if ($key === null) {
            return $category;
        }

        $cacheKey = "translator.{$category}.{$key}";
        $row = Cache::remember($cacheKey, 3600, function () use ($category, $key) {
            return SiteTranslation::where('category', $category)
                ->where('key', $key)
                ->where('is_published', true)
                ->first();
        });

        if (! $row) {
            return $key;
        }

        $value = $row->value;

        if (is_array($value) && isset($value[$locale])) {
            $value = $value[$locale];
        } elseif (is_array($value)) {
            $value = reset($value);
        }

        if (is_array($replace)) {
            foreach ($replace as $k => $v) {
                $value = str_replace(':'.$k, $v, $value);
            }
        }

        return $value;
    }
}

if (! function_exists('translator_text')) {
    /**
     * Get translation as plain text (no HTML)
     */
    function translator_text($category, $key = null, $replace = [], $locale = null): string
    {
        $value = translator($category, $key, $replace, $locale);

        return strip_tags(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
    }
}

if (! function_exists('translator_br')) {
    /**
     * Get translation with <br> tags support
     */
    function translator_br($category, $key = null, $replace = [], $locale = null): string
    {
        $value = translator($category, $key, $replace, $locale);
        $value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
        $value = preg_replace('/<\/p>\s*<p>/i', '{{BR}}', $value);

        return str_replace('{{BR}}', '<br>', $value);
    }
}

if (! function_exists('translator_html')) {
    /**
     * Get translation as safe HTML
     */
    function translator_html($category, $key = null, $replace = [], $locale = null): string
    {
        $value = translator($category, $key, $replace, $locale);

        if (function_exists('clean')) {
            return clean($value);
        }

        return strip_tags($value, '<p><br><strong><b><em><i><ul><ol><li><a>');
    }
}

if (! function_exists('clear_translator_cache')) {
    /**
     * Clear translator cache
     */
    function clear_translator_cache(?string $category = null, ?string $key = null): void
    {
        if ($category && $key) {
            Cache::forget("translator.{$category}.{$key}");
        } elseif ($category) {
            SiteTranslation::where('category', $category)->each(function ($translation) use ($category) {
                Cache::forget("translator.{$category}.{$translation->key}");
            });
        } else {
            SiteTranslation::all()->each(function ($translation) {
                Cache::forget("translator.{$translation->category}.{$translation->key}");
            });
        }
    }
}
