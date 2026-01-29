<?php

namespace App\Filament\Plugins;

use App\Models\User;
use Filament\Contracts\Plugin;
use Filament\Panel;
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
    }

    protected function getFontsLink(): string
    {
        return <<<HTML
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Public+Sans:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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
