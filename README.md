# Filament 4 Starter Kit

Стартовый шаблон на **Laravel 12** + **Filament 4** с готовой системой настроек, переводов и SEO.

## Возможности

### Админ-панель (Filament)
- **Shield** — управление ролями и правами доступа
- **Breezy** — страница профиля пользователя
- **Logger** — логирование действий пользователей
- **Language Switch** — переключение языков в админке
- **Translatable Tabs** — удобные табы для мультиязычного контента

### Настройки сайта
- **Settings** — главные настройки (SEO, метрики)
- **SiteSettings** — произвольные key-value настройки
- **SiteTranslations** — переводы из базы данных

### Готовые хелперы
```php
// Получить настройку
settings('seo.title.ru');
settings('metrics.yandex');

// Произвольные настройки
site_setting('contact_phone');

// Переводы из БД
translator('home.welcome');
translator('buttons', 'submit');
```

### Кеширование
- Все данные кешируются автоматически
- При изменении в админке кеш очищается через Observers
- Ручная очистка: `php artisan project:cache`

## Установка

### 1. Требования

- [Docker](https://www.docker.com/) + Docker Compose
- [Node.js](https://nodejs.org/) — на машине разработчика (для Vite)

> Composer установлен внутри Docker контейнера. Node.js нужен только на dev машине и CI/CD — на продакшн сервере не нужен.

### 2. Создание проекта
```bash
laravel new my-project --using=ercogx/laravel-filament-starter-kit
```

### 2. Настройка `.env`

Перед запуском поправь `.env`:
```env
APP_URL=http://localhost

DB_USERNAME=app          # не использовать root!
DB_PASSWORD=secret
DB_ROOT_PASSWORD=secret
```

> ⚠️ На продакшне замени все пароли на сложные!

---

### 3. Первый запуск — одна команда

```bash
make install
```

Делает всё автоматически:
- Копирует `.env.example` → `.env` (если ещё нет)
- Поднимает Docker контейнеры
- Генерирует `APP_KEY`
- Запускает `project:init` (миграции, seed, shield, super-admin)
- Запускает `make:filament-user` — введи имя/email/пароль

| Сервис     | URL                       |
|------------|---------------------------|
| Приложение | http://localhost          |
| phpMyAdmin | http://localhost:8080     |
| Mailpit    | http://localhost:8025     |

---

### 4. Повторный запуск (уже установлено)

```bash
make dev
```

Поднимает контейнеры и запускает Vite (hot reload).

---

### 5. Продакшн

```bash
# Первая установка
make install
npm run build   # собрать фронтенд (один раз)

# В .env:
APP_ENV=production
APP_DEBUG=false
```

---

### 6. Обновление (после изменений в коде)

```bash
docker compose exec app php artisan project:update
docker compose exec app npm run build   # если менялся JS/CSS
```

---

### Все Makefile команды

```bash
make install      # установка с нуля (первый запуск)
make dev          # запуск dev окружения
make up           # запустить контейнеры
make down         # остановить контейнеры
make shell        # войти в контейнер
make migrate      # запустить миграции
make fresh        # migrate:fresh --seed
make test         # запустить тесты
make cache-clear  # очистить кеш
```

---

### Локальный запуск (без Docker)

```bash
cp .env.example .env
# Настройте БД в .env
php artisan key:generate
php artisan project:init
php artisan make:filament-user
composer dev
```
Откроется: http://127.0.0.1:8000/admin

## Структура проекта

```
app/
├── Filament/
│   ├── Pages/
│   │   └── Settings.php          # Страница настроек (SEO, метрики)
│   └── Resources/
│       ├── SiteSettings/         # CRUD для произвольных настроек
│       ├── SiteTranslations/     # CRUD для переводов
│       └── Users/                # Управление пользователями
├── Helpers/
│   └── functions.php             # Хелперы: settings(), translator()
├── Models/
│   ├── Settings.php              # Главные настройки
│   ├── SiteSettings.php          # Произвольные настройки
│   └── SiteTranslation.php       # Переводы
└── Observers/                    # Автоочистка кеша
```

## Использование

### SEO настройки
В админке: **Settings → SEO**
- Title (мультиязычный)
- Description (мультиязычный)
- Keywords (мультиязычный)
- OG Image

В шаблонах:
```blade
<title>{{ settings('seo.title.' . app()->getLocale()) }}</title>
<meta name="description" content="{{ settings('seo.description.' . app()->getLocale()) }}">
```

### Метрики
В админке: **Settings → Metrics**
- Yandex Metrika (HTML/JS код)
- Google Analytics (HTML/JS код)

```blade
{!! settings('metrics.yandex') !!}
{!! settings('metrics.google') !!}
```

### Переводы из БД
```php
// Создайте перевод в админке:
// category: home, key: welcome, value: {"uz": "Salom", "ru": "Привет", "en": "Hello"}

// Используйте в коде:
translator('home.welcome');              // Привет (текущая локаль)
translator('home', 'welcome', [], 'en'); // Hello
translator_text('home.welcome');         // Без HTML тегов
translator_html('home.welcome');         // Безопасный HTML
```

### Произвольные настройки
```php
// Создайте в админке: name: contact_phone, value: +998 90 123 45 67

site_setting('contact_phone'); // +998 90 123 45 67
```

## Artisan команды

```bash
# Пересобрать кеш (включая settings, site_settings, translations)
php artisan project:cache

# Инициализация проекта
php artisan project:init

# Обновление проекта
php artisan project:update

# Проверка кода (pint + tests + phpstan)
composer check
```

## Очистка кеша

Кеш очищается автоматически при изменении данных. Для ручной очистки:

```php
// В коде
clear_settings_cache();           // Все настройки
clear_settings_cache('seo.title.ru'); // Конкретный ключ

clear_site_settings_cache();      // Все site_settings
clear_translator_cache();         // Все переводы
clear_translator_cache('home');   // Категория
clear_translator_cache('home', 'welcome'); // Конкретный перевод
```

```bash
# Через artisan
php artisan project:cache
php artisan cache:clear
```

## Зависимости

| Пакет | Описание |
|-------|----------|
| filament/filament | Админ-панель |
| bezhansalleh/filament-shield | Роли и права |
| jeffgreco13/filament-breezy | Профиль пользователя |
| jacobtims/filament-logger | Логирование |
| spatie/laravel-translatable | Мультиязычность |
| abdulmajeed-jamaan/filament-translatable-tabs | Табы для переводов |
