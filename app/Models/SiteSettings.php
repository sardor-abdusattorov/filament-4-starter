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
        'is_published' => 'boolean',
    ];

    /**
     * Get the value attribute - decode JSON if it's a valid JSON array/object
     */
    public function getValueAttribute($value)
    {
        if ($value === null) {
            return null;
        }

        $decoded = json_decode($value, true);

        // If it's a valid JSON array/object, return decoded
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        // If it was a JSON-encoded string (like "\"text\""), decode it
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }

        // Otherwise return as-is
        return $value;
    }

    /**
     * Set the value attribute - encode arrays to JSON, store strings as-is
     */
    public function setValueAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['value'] = json_encode($value, JSON_UNESCAPED_UNICODE);
        } else {
            $this->attributes['value'] = $value;
        }
    }

    public static function getStatusOptions(): array
    {
        return [
            self::STATUS_PUBLISHED => __('app.status.published'),
            self::STATUS_UNPUBLISHED => __('app.status.unpublished'),
        ];
    }
}
