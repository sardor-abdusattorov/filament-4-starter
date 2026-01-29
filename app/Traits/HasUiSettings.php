<?php

namespace App\Traits;

trait HasUiSettings
{
    /**
     * Get a specific UI setting value.
     */
    public function getUiSetting(string $key, mixed $default = null): mixed
    {
        return data_get($this->ui_settings, $key, $default);
    }

    /**
     * Set a specific UI setting value.
     */
    public function setUiSetting(string $key, mixed $value): void
    {
        $settings = $this->ui_settings ?? [];
        data_set($settings, $key, $value);
        $this->ui_settings = $settings;
        $this->save();
    }

    /**
     * Get default UI settings.
     */
    public static function getDefaultUiSettings(): array
    {
        return config('ui-switcher.defaults', [
            'theme' => 'system',
            'primary_color' => 'blue',
            'layout' => 'sidebar',
            'font_family' => 'Inter',
            'font_size' => 16,
        ]);
    }

    /**
     * Get merged UI settings with defaults.
     */
    public function getMergedUiSettings(): array
    {
        return array_merge(static::getDefaultUiSettings(), $this->ui_settings ?? []);
    }
}
