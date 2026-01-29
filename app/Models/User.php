<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use HasPanelShield;
    use HasRoles;
    use Notifiable;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'ui_settings' => 'array',
    ];

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


    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null;
    }
}
