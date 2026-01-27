<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SiteTranslation extends Model
{
    use HasTranslations;

    public const STATUS_PUBLISHED = true;
    public const STATUS_UNPUBLISHED = false;

    protected $table = 'site_translations';

    protected $fillable = ['category', 'key', 'value', 'is_published'];

    public $translatable = ['value'];

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
