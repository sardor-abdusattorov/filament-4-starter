<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Settings;
use Illuminate\Support\Facades\Cache;

class SettingsObserver
{
    public function created(Settings $setting): void
    {
        $this->clearCache($setting);
    }

    public function updated(Settings $setting): void
    {
        $this->clearCache($setting);
    }

    public function deleted(Settings $setting): void
    {
        $this->clearCache($setting);
    }

    protected function clearCache(Settings $setting): void
    {
        Cache::forget("settings.{$setting->key}");
    }
}
