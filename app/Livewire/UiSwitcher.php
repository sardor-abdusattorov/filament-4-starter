<?php

namespace App\Livewire;

use Filament\Support\Colors\Color;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class UiSwitcher extends Component
{
    public bool $isOpen = false;

    public string $theme = 'system';
    public string $primaryColor = 'blue';
    public string $layout = 'sidebar';
    public string $fontFamily = 'Inter';
    public int $fontSize = 16;

    public array $availableColors = [
        'slate' => '#64748b',
        'gray' => '#6b7280',
        'zinc' => '#71717a',
        'neutral' => '#737373',
        'stone' => '#78716c',
        'red' => '#ef4444',
        'orange' => '#f97316',
        'amber' => '#f59e0b',
        'yellow' => '#eab308',
        'lime' => '#84cc16',
        'green' => '#22c55e',
        'emerald' => '#10b981',
        'teal' => '#14b8a6',
        'cyan' => '#06b6d4',
        'sky' => '#0ea5e9',
        'blue' => '#3b82f6',
        'indigo' => '#6366f1',
        'violet' => '#8b5cf6',
        'purple' => '#a855f7',
        'fuchsia' => '#d946ef',
        'pink' => '#ec4899',
        'rose' => '#f43f5e',
    ];

    public array $availableFonts = [
        'Inter' => 'Inter',
        'Poppins' => 'Poppins',
        'Public Sans' => 'Public Sans',
        'DM Sans' => 'DM Sans',
        'Nunito Sans' => 'Nunito Sans',
        'Roboto' => 'Roboto',
    ];

    public array $availableLayouts = [
        'sidebar' => 'Sidebar',
        'topbar' => 'Topbar',
    ];

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
        $this->dispatch('ui-settings-changed', setting: 'theme', value: $theme);
    }

    public function setPrimaryColor(string $color): void
    {
        $this->primaryColor = $color;
        $this->saveSetting('primary_color', $color);
        $this->dispatch('ui-settings-changed', setting: 'primary_color', value: $color);
    }

    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
        $this->saveSetting('layout', $layout);
        $this->dispatch('ui-settings-changed', setting: 'layout', value: $layout);
    }

    public function setFontFamily(string $font): void
    {
        $this->fontFamily = $font;
        $this->saveSetting('font_family', $font);
        $this->dispatch('ui-settings-changed', setting: 'font_family', value: $font);
    }

    public function setFontSize(int $size): void
    {
        $this->fontSize = $size;
        $this->saveSetting('font_size', $size);
        $this->dispatch('ui-settings-changed', setting: 'font_size', value: $size);
    }

    public function resetSettings(): void
    {
        $user = Auth::user();
        if (! $user) {
            return;
        }

        $user->ui_settings = null;
        $user->save();

        $this->loadSettings();
        $this->dispatch('ui-settings-reset');
    }

    protected function saveSetting(string $key, mixed $value): void
    {
        $user = Auth::user();
        if (! $user) {
            return;
        }

        $user->setUiSetting($key, $value);
    }

    public function render(): View
    {
        return view('livewire.ui-switcher');
    }
}
