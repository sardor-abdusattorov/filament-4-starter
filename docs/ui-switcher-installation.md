# UI Switcher для Filament 4

Пользовательские настройки UI для Filament 4: тема, цвет, layout, шрифт.

## Установка

### 1. Скопируйте файлы

```
app/Filament/Plugins/UiSwitcherPlugin.php
app/Livewire/UiSwitcher.php
config/ui-switcher.php
resources/views/livewire/ui-switcher.blade.php
database/migrations/2026_01_29_000001_add_ui_settings_to_users_table.php
```

### 2. Обновите модель User

Добавьте в `app/Models/User.php`:

```php
protected $casts = [
    // ... другие casts
    'ui_settings' => 'array',
];

public function getUiSetting(string $key, mixed $default = null): mixed
{
    return data_get($this->ui_settings, $key, $default);
}

public function setUiSetting(string $key, mixed $value): void
{
    $settings = $this->ui_settings ?? [];
    data_set($settings, $key, $value);
    $this->ui_settings = $settings;
    $this->save();
}

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

public function getMergedUiSettings(): array
{
    return array_merge(static::getDefaultUiSettings(), $this->ui_settings ?? []);
}
```

### 3. Зарегистрируйте плагин

В `app/Providers/Filament/AdminPanelProvider.php`:

```php
use App\Filament\Plugins\UiSwitcherPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugins([
            UiSwitcherPlugin::make(),
            // другие плагины
        ]);
}
```

### 4. Добавьте source в theme.css

В `resources/css/filament/admin/theme.css`:

```css
@source '../../../../resources/views/livewire/**/*';
```

### 5. Запустите миграцию

```bash
php artisan migrate
```

### 6. Пересоберите ассеты

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
    'layouts' => ['sidebar', 'topbar'],
    'defaults' => [
        'theme' => 'system',
        'primary_color' => 'blue',
        'layout' => 'sidebar',
        'font_family' => 'Inter',
        'font_size' => 16,
    ],
    'font_size' => ['min' => 12, 'max' => 20],
];
```

## Возможности

- **Тема:** Light / Dark / System
- **Layout:** Sidebar / Topbar
- **Цвет:** 22 цвета Tailwind
- **Шрифт:** 6 Google Fonts
- **Размер шрифта:** 12-20px
- Настройки сохраняются в БД для каждого пользователя
