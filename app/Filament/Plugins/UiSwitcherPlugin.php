<?php

namespace App\Filament\Plugins;

use App\Models\User;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

class UiSwitcherPlugin implements Plugin
{
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

        // Apply dynamic primary color based on user settings
        $this->applyUserSettings($panel);
    }

    protected function getFontsLink(): string
    {
        return <<<HTML
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Public+Sans:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        HTML;
    }

    protected function applyUserSettings(Panel $panel): void
    {
        $user = Auth::user();
        if (! $user instanceof User) {
            return;
        }

        $settings = $user->getMergedUiSettings();

        // Apply primary color
        $colorName = $settings['primary_color'] ?? 'blue';
        $colorClass = $this->getColorClass($colorName);
        if ($colorClass) {
            $panel->colors(['primary' => $colorClass]);
        }

        // Apply font
        $fontFamily = $settings['font_family'] ?? 'Inter';
        $panel->font($fontFamily);

        // Apply layout (topNavigation)
        $layout = $settings['layout'] ?? 'sidebar';
        if ($layout === 'topbar') {
            $panel->topNavigation();
        }
    }

    protected function getColorClass(string $colorName): ?array
    {
        $colors = [
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

        return $colors[$colorName] ?? null;
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
                        // System preference
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

                // Apply font family (backup in case the PHP side didn't work)
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
