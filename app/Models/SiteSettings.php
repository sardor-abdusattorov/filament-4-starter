<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    public const STATUS_PUBLISHED = true;
    public const STATUS_UNPUBLISHED = false;

    protected $table = 'site_settings';

    protected $fillable = ['name', 'value', 'is_published'];

    protected $casts = [
        'value' => 'array',
        'is_published' => 'boolean',
    ];

    public static function getStatusOptions(): array
    {
        return [
            self::STATUS_PUBLISHED => __('app.status.published'),
            self::STATUS_UNPUBLISHED => __('app.status.unpublished'),
        ];
    }

}
