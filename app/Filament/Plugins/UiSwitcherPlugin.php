<?php

namespace App\Filament\Plugins;

use App\Models\User;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

class UiSwitcherPlugin implements Plugin
{
    protected static array $colorMap = [
        'slate' => Color::Slate,
        'gray' => Color::Gray,
        'zinc' => Color::Zinc,
        'neutral' => Color::Neutral,
        'stone' => Color::Stone,
        'red' => Color::Red,
        'orange' => Color::Orange,
        'amber' => Color::Amber,
        'yellow' => Color::Yellow,
        'lime' => Color::Lime,
        'green' => Color::Green,
        'emerald' => Color::Emerald,
        'teal' => Color::Teal,
        'cyan' => Color::Cyan,
        'sky' => Color::Sky,
        'blue' => Color::Blue,
        'indigo' => Color::Indigo,
        'violet' => Color::Violet,
        'purple' => Color::Purple,
        'fuchsia' => Color::Fuchsia,
        'pink' => Color::Pink,
        'rose' => Color::Rose,
    ];

    public function getId(): string
    {
        return 'ui-switcher';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        // Register colors dynamically based on user settings
        $this->registerUserColors();

        // Register Google Fonts in the head
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_END,
            fn (): string => $this->getFontsLink(),
        );

        // Register the UI Switcher component in the user menu
        FilamentView::registerRenderHook(
            PanelsRenderHook::USER_MENU_BEFORE,
            fn (): string => Blade::render('@livewire(\'ui-switcher\')'),
        );

        // Register script to apply settings on page load
        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_END,
            fn (): string => $this->getInitScript(),
        );
    }

    protected function registerUserColors(): void
    {
        FilamentColor::register(function () {
            $user = Auth::user();
            if (! $user instanceof User) {
                return [];
            }

            $settings = $user->getMergedUiSettings();
            $colorName = $settings['primary_color'] ?? 'blue';

            if (! isset(self::$colorMap[$colorName])) {
                return [];
            }

            return [
                'primary' => self::$colorMap[$colorName],
            ];
        });
    }

    protected function getFontsLink(): string
    {
        return <<<HTML
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=Nunito+Sans:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&family=Public+Sans:wght@400;500;600;700&family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
        HTML;
    }

    protected function getInitScript(): string
    {
        $user = Auth::user();
        if (! $user instanceof User) {
            return '';
        }

        $settings = $user->getMergedUiSettings();
        $settingsJson = json_encode($settings);

        return <<<HTML
        <script>
            (function() {
                const settings = {$settingsJson};

                // Apply theme
                if (settings.theme) {
                    const html = document.documentElement;
                    if (settings.theme === 'dark') {
                        html.classList.add('dark');
                    } else if (settings.theme === 'light') {
                        html.classList.remove('dark');
                    } else {
                        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                            html.classList.add('dark');
                        } else {
                            html.classList.remove('dark');
                        }
                    }
                }

                // Apply font size
                if (settings.font_size) {
                    document.documentElement.style.fontSize = settings.font_size + 'px';
                }

                // Apply font family
                if (settings.font_family) {
                    document.body.style.fontFamily = '"' + settings.font_family + '", ui-sans-serif, system-ui, sans-serif';
                }
            })();
        </script>
        HTML;
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        return filament(app(static::class)->getId());
    }
}
