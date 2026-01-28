<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\SiteTranslation;
use Illuminate\Support\Facades\Cache;

class SiteTranslationObserver
{
    public function created(SiteTranslation $translation): void
    {
        $this->clearCache($translation);
    }

    public function updated(SiteTranslation $translation): void
    {
        $this->clearCache($translation);
    }

    public function deleted(SiteTranslation $translation): void
    {
        $this->clearCache($translation);
    }

    protected function clearCache(SiteTranslation $translation): void
    {
        Cache::forget("translator.{$translation->category}.{$translation->key}");
    }
}
