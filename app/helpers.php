<?php

use App\Models\SiteSettings;
use App\Models\SiteTranslation;
use Illuminate\Support\Facades\Cache;

if (! function_exists('site_setting')) {
    /**
     * Получить настройку сайта из базы данных с кэшированием
     *
     * @param  string  $key  Ключ настройки
     * @param  mixed  $default  Значение по умолчанию
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
     * Очистить кэш настроек сайта
     *
     * @param  string|null  $key  Ключ настройки (если null - очистить все)
     */
    function clear_site_settings_cache(?string $key = null): void
    {
        if ($key) {
            Cache::forget("site_setting.{$key}");
        } else {
            // Получаем все настройки и очищаем их кэш
            SiteSettings::all()->each(function ($setting) {
                Cache::forget("site_setting.{$setting->name}");
            });
        }
    }
}

if (! function_exists('translator')) {
    /**
     * Получить перевод из базы данных с кэшированием
     * Возвращает RAW текст - используйте translator_text() или translator_html() для безопасного вывода
     *
     * @param  string  $category  Категория перевода
     * @param  string|null  $key  Ключ перевода
     * @param  array  $replace  Массив замен
     * @param  string|null  $locale  Локаль
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

        // Кэширование на 1 час
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
     * Получить перевод как ЧИСТЫЙ ТЕКСТ (без HTML)
     * Безопасно для вывода в любом месте
     * Использование: {{ translator_text('app', 'key') }}
     *
     * @param  string  $category  Категория перевода
     * @param  string|null  $key  Ключ перевода
     * @param  array  $replace  Массив замен
     * @param  string|null  $locale  Локаль
     * @return string
     */
    function translator_text($category, $key = null, $replace = [], $locale = null): string
    {
        $value = translator($category, $key, $replace, $locale);

        return strip_tags(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
    }
}

if (! function_exists('translator_br')) {
    /**
     * Получить перевод с поддержкой <br> тегов (для заголовков с переносами)
     * Удаляет все теги кроме <br>, экранирует остальное
     * Использование: {!! translator_br('app', 'key') !!}
     *
     * @param  string  $category  Категория перевода
     * @param  string|null  $key  Ключ перевода
     * @param  array  $replace  Массив замен
     * @param  string|null  $locale  Локаль
     * @return string
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
     * Получить перевод как БЕЗОПАСНЫЙ HTML (очищенный через HTMLPurifier)
     * Для контента с форматированием (жирный, списки, ссылки)
     * Использование: {!! translator_html('app', 'key') !!}
     *
     * @param  string  $category  Категория перевода
     * @param  string|null  $key  Ключ перевода
     * @param  array  $replace  Массив замен
     * @param  string|null  $locale  Локаль
     * @return string
     */
    function translator_html($category, $key = null, $replace = [], $locale = null): string
    {
        $value = translator($category, $key, $replace, $locale);

        // Проверяем доступность HTMLPurifier через функцию clean()
        if (function_exists('clean')) {
            return clean($value);
        }

        // Fallback: strip_tags с разрешёнными тегами
        return strip_tags($value, '<p><br><strong><b><em><i><ul><ol><li><a>');
    }
}

if (! function_exists('clear_translator_cache')) {
    /**
     * Очистить кэш переводов
     * Вызывать при обновлении переводов в админке
     *
     * @param  string|null  $category  Категория
     * @param  string|null  $key  Ключ
     */
    function clear_translator_cache(?string $category = null, ?string $key = null): void
    {
        if ($category && $key) {
            Cache::forget("translator.{$category}.{$key}");
        } elseif ($category) {
            // Очистить все переводы в категории
            SiteTranslation::where('category', $category)->each(function ($translation) use ($category) {
                Cache::forget("translator.{$category}.{$translation->key}");
            });
        } else {
            // Очистить все переводы
            SiteTranslation::all()->each(function ($translation) {
                Cache::forget("translator.{$translation->category}.{$translation->key}");
            });
        }
    }
}
