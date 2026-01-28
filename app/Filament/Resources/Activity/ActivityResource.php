<?php

namespace App\Filament\Resources\Activity;

use Jacobtims\FilamentLogger\Resources\ActivityResource as BaseResource;

class ActivityResource extends BaseResource
{
    /**
     * The resource navigation sort order.
     */
    protected static ?int $navigationSort = 6;

    /**
     * Get the navigation badge for the resource.
     */
    public static function getNavigationBadge(): ?string
    {
        return number_format(static::getModel()::count());
    }

    public static function getNavigationGroup(): ?string
    {
        return __('app.label.administration');
    }

}
