<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Filament\Facades\Filament;
use Filament\Support\Colors\Color;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplyUiSettings
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user instanceof User) {
            $settings = $user->getMergedUiSettings();
            $panel = Filament::getCurrentPanel();

            if ($panel) {
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
        }

        return $next($request);
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
}
