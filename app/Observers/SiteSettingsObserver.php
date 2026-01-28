<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\SiteSettings;
use Illuminate\Support\Facades\Cache;

class SiteSettingsObserver
{
    public function created(SiteSettings $setting): void
    {
        $this->clearCache($setting);
    }

    public function updated(SiteSettings $setting): void
    {
        $this->clearCache($setting);
    }

    public function deleted(SiteSettings $setting): void
    {
        $this->clearCache($setting);
    }

    protected function clearCache(SiteSettings $setting): void
    {
        Cache::forget("site_setting.{$setting->name}");
    }
}
