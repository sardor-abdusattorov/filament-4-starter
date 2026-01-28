<?php

namespace Database\Seeders;

use App\Models\SiteTranslation;
use Illuminate\Database\Seeder;

class SiteTranslationSeeder extends Seeder
{
    public function run(): void
    {
        $translations = [
            // Home page translations
            [
                'category' => 'home',
                'key' => 'dashboard',
                'value' => [
                    'ru' => 'Панель управления',
                    'uz' => 'Boshqaruv paneli',
                    'en' => 'Dashboard',
                ],
            ],
            [
                'category' => 'home',
                'key' => 'login',
                'value' => [
                    'ru' => 'Войти',
                    'uz' => 'Kirish',
                    'en' => 'Login',
                ],
            ],
            [
                'category' => 'home',
                'key' => 'welcome',
                'value' => [
                    'ru' => 'Добро пожаловать',
                    'uz' => 'Xush kelibsiz',
                    'en' => 'Welcome',
                ],
            ],
            [
                'category' => 'home',
                'key' => 'welcome_description',
                'value' => [
                    'ru' => 'Современная и мощная платформа для управления вашим проектом',
                    'uz' => 'Loyihangizni boshqarish uchun zamonaviy va kuchli platforma',
                    'en' => 'A modern and powerful platform for managing your project',
                ],
            ],
            [
                'category' => 'home',
                'key' => 'go_to_dashboard',
                'value' => [
                    'ru' => 'Перейти в панель',
                    'uz' => 'Panelga o\'tish',
                    'en' => 'Go to Dashboard',
                ],
            ],
            [
                'category' => 'home',
                'key' => 'get_started',
                'value' => [
                    'ru' => 'Начать работу',
                    'uz' => 'Boshlash',
                    'en' => 'Get Started',
                ],
            ],
            [
                'category' => 'home',
                'key' => 'feature_secure',
                'value' => [
                    'ru' => 'Безопасность',
                    'uz' => 'Xavfsizlik',
                    'en' => 'Security',
                ],
            ],
            [
                'category' => 'home',
                'key' => 'feature_secure_desc',
                'value' => [
                    'ru' => 'Надёжная защита данных и контроль доступа',
                    'uz' => 'Ishonchli ma\'lumotlar himoyasi va kirish nazorati',
                    'en' => 'Reliable data protection and access control',
                ],
            ],
            [
                'category' => 'home',
                'key' => 'feature_fast',
                'value' => [
                    'ru' => 'Производительность',
                    'uz' => 'Tezkorlik',
                    'en' => 'Performance',
                ],
            ],
            [
                'category' => 'home',
                'key' => 'feature_fast_desc',
                'value' => [
                    'ru' => 'Быстрая работа и оптимизированный код',
                    'uz' => 'Tez ishlash va optimallashtirilgan kod',
                    'en' => 'Fast operation and optimized code',
                ],
            ],
            [
                'category' => 'home',
                'key' => 'feature_multilang',
                'value' => [
                    'ru' => 'Мультиязычность',
                    'uz' => 'Ko\'p tillilik',
                    'en' => 'Multilingual',
                ],
            ],
            [
                'category' => 'home',
                'key' => 'feature_multilang_desc',
                'value' => [
                    'ru' => 'Поддержка нескольких языков из коробки',
                    'uz' => 'Bir nechta tillarni qo\'llab-quvvatlash',
                    'en' => 'Multiple language support out of the box',
                ],
            ],
            [
                'category' => 'home',
                'key' => 'all_rights_reserved',
                'value' => [
                    'ru' => 'Все права защищены',
                    'uz' => 'Barcha huquqlar himoyalangan',
                    'en' => 'All rights reserved',
                ],
            ],
        ];

        foreach ($translations as $translation) {
            SiteTranslation::updateOrCreate(
                [
                    'category' => $translation['category'],
                    'key' => $translation['key'],
                ],
                [
                    'value' => $translation['value'],
                    'is_published' => true,
                ]
            );
        }
    }
}
