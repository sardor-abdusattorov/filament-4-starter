<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UiSwitcher extends Component
{
    public bool $isOpen = false;

    public string $theme = 'system';
    public string $primaryColor = 'blue';
    public string $layout = 'sidebar';
    public string $fontFamily = 'Inter';
    public int $fontSize = 16;

    public function mount(): void
    {
        $this->loadSettings();
    }

    protected function loadSettings(): void
    {
        $user = Auth::user();
        if (! $user) {
            return;
        }

        $settings = $user->getMergedUiSettings();

        $this->theme = $settings['theme'] ?? 'system';
        $this->primaryColor = $settings['primary_color'] ?? 'blue';
        $this->layout = $settings['layout'] ?? 'sidebar';
        $this->fontFamily = $settings['font_family'] ?? 'Inter';
        $this->fontSize = $settings['font_size'] ?? 16;
    }

    public function toggle(): void
    {
        $this->isOpen = ! $this->isOpen;
    }

    public function close(): void
    {
        $this->isOpen = false;
    }

    public function setTheme(string $theme): void
    {
        $this->theme = $theme;
        $this->saveSetting('theme', $theme);
    }

    public function setPrimaryColor(string $color): void
    {
        $this->primaryColor = $color;
        $this->saveSetting('primary_color', $color);
        $this->dispatch('reload-page');
    }

    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
        $this->saveSetting('layout', $layout);
        $this->dispatch('layout-changed', layout: $layout);
    }

    public function setFontFamily(string $font): void
    {
        $this->fontFamily = $font;
        $this->saveSetting('font_family', $font);
        $this->dispatch('reload-page');
    }

    public function updatedFontSize(): void
    {
        $this->saveSetting('font_size', $this->fontSize);
        $this->dispatch('font-size-changed', size: $this->fontSize);
    }

    public function resetSettings(): void
    {
        $user = Auth::user();
        if (! $user) {
            return;
        }

        $user->ui_settings = null;
        $user->save();

        $defaults = $user->getDefaultUiSettings();
        $this->dispatch('reset-settings', layout: $defaults['layout'] ?? 'sidebar_collapsible');
    }

    public function saveSetting(string $key, mixed $value): void
    {
        $user = Auth::user();
        if (! $user) {
            return;
        }

        $user->setUiSetting($key, $value);
    }

    public function getColors(): array
    {
        return config('ui-switcher.colors', []);
    }

    public function getFonts(): array
    {
        return config('ui-switcher.fonts', []);
    }

    public function render(): View
    {
        return view('livewire.ui-switcher', [
            'colors' => $this->getColors(),
            'fonts' => $this->getFonts(),
        ]);
    }
}
