<?php

namespace Database\Seeders;

use App\Models\SiteSettings;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'name' => 'site_name',
                'value' => 'Filament Starter',
            ],
            [
                'name' => 'contact_email',
                'value' => 'info@example.com',
            ],
            [
                'name' => 'contact_phone',
                'value' => '+998 90 123 45 67',
            ],
            [
                'name' => 'social_telegram',
                'value' => 'https://t.me/example',
            ],
            [
                'name' => 'social_instagram',
                'value' => 'https://instagram.com/example',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSettings::updateOrCreate(
                ['name' => $setting['name']],
                [
                    'value' => $setting['value'],
                    'is_published' => true,
                ]
            );
        }
    }
}
