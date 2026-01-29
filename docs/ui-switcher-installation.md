# UI Switcher для Filament 4

Пользовательские настройки UI для Filament 4: тема, цвет, layout, шрифт.

## Установка

### 1. Скопируйте файлы

```
app/Filament/Plugins/UiSwitcherPlugin.php
app/Livewire/UiSwitcher.php
app/Traits/HasUiSettings.php
config/ui-switcher.php
resources/views/livewire/ui-switcher.blade.php
database/migrations/2026_01_29_000001_add_ui_settings_to_users_table.php
```

### 2. Обновите модель User

Добавьте trait и cast в `app/Models/User.php`:

```php
use App\Traits\HasUiSettings;

class User extends Authenticatable
{
    use HasUiSettings;

    protected $casts = [
        // ... другие casts
        'ui_settings' => 'array',
    ];
}
```

### 3. Зарегистрируйте плагин и настройте layout

В `app/Providers/Filament/AdminPanelProvider.php`:

```php
use App\Filament\Plugins\UiSwitcherPlugin;
use Filament\Enums\ThemeMode;

public function panel(Panel $panel): Panel
{
    $panel = $panel
        ->default()
        ->id('admin')
        ->path('admin')
        ->darkMode(true)
        ->defaultThemeMode(ThemeMode::System)
        // ... другие настройки
        ->plugins([
            UiSwitcherPlugin::make(),
            // другие плагины
        ]);

    // Apply layout from cookie (set by UI Switcher)
    $layout = $_COOKIE['filament_layout'] ?? 'sidebar_collapsible';

    return match ($layout) {
        'topbar' => $panel->topNavigation(),
        'sidebar_hidden' => $panel->sidebarFullyCollapsibleOnDesktop(),
        'sidebar_collapsible' => $panel->sidebarCollapsibleOnDesktop(),
        default => $panel, // 'sidebar' - default, no modification
    };
}
```

### 4. Добавьте переводы

В языковые файлы (`lang/en/app.php`, `lang/ru/app.php`, etc.):

```php
'ui_switcher' => [
    'title' => 'UI Settings',
    'settings' => 'Settings',
    'mode' => 'Mode',
    'layout' => 'Layout',
    'color' => 'Color',
    'font' => 'Font',
    'size' => 'Size',
    'reset' => 'Reset to defaults',
    'layouts' => [
        'sidebar' => 'Sidebar',
        'sidebar_collapsible' => 'Collapsible',
        'sidebar_hidden' => 'Hidden',
        'topbar' => 'Topbar',
    ],
],
```

### 5. Добавьте source в theme.css

В `resources/css/filament/admin/theme.css`:

```css
@source '../../../../resources/views/livewire/**/*';
```

### 6. Запустите миграцию

```bash
php artisan migrate
```

### 7. Пересоберите ассеты

```bash
npm run build
php artisan optimize:clear
```

## Настройка

Редактируйте `config/ui-switcher.php`:

```php
return [
    'colors' => ['blue', 'green', 'red', ...],
    'fonts' => ['Inter', 'Poppins', ...],
    'layouts' => ['sidebar', 'sidebar_collapsible', 'sidebar_hidden', 'topbar'],
    'defaults' => [
        'theme' => 'system',
        'primary_color' => 'blue',
        'layout' => 'sidebar_collapsible',
        'font_family' => 'Inter',
        'font_size' => 16,
    ],
    'font_size' => ['min' => 12, 'max' => 20],
];
```

## Возможности

- **Тема:** Light / Dark / System (мгновенное переключение)
- **Layout:** 4 варианта
  - Sidebar - обычная боковая панель
  - Collapsible - сворачиваемая боковая панель
  - Hidden - полностью скрываемая боковая панель
  - Topbar - верхняя навигация
- **Цвет:** 22 цвета Tailwind
- **Шрифт:** 6 Google Fonts
- **Размер шрифта:** 12-20px
- Настройки сохраняются в БД для каждого пользователя
- Layout сохраняется в cookie для применения до авторизации
