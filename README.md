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
settings('seo.title.ru');
settings('metrics.yandex');
site_setting('contact_phone');
translator('home.welcome');
```

### Кеширование
- Все данные кешируются автоматически через Redis
- При изменении в админке кеш очищается через Observers
- Ручная очистка: `php artisan project:cache`

---

## Установка

### Требования
- [Docker](https://www.docker.com/) + Docker Compose
- [Node.js](https://nodejs.org/) — на машине разработчика (для Vite)

> Composer установлен внутри Docker контейнера — дополнительно устанавливать не нужно.

---

### Шаг 1 — Настройка `.env`

```bash
cp .env.example .env
```

Поправь значения:
```env
APP_URL=http://localhost

DB_USERNAME=app
DB_PASSWORD=secret
DB_ROOT_PASSWORD=secret
```

> ⚠️ На продакшне замени все пароли на сложные!

---

### Шаг 2 — Первый запуск

**Windows:**
```bash
install.bat
```

**Linux / Mac:**
```bash
make install
```

Делает всё автоматически:
1. Поднимает Docker контейнеры
2. Устанавливает PHP зависимости (`composer install`)
3. Устанавливает JS зависимости (`npm install`)
4. Генерирует `APP_KEY`
5. Запускает миграции, seed, shield
6. Создаёт admin пользователя (введи имя/email/пароль)

---

### Шаг 3 — Запуск Vite (для разработки)

**Windows:**
```bash
dev.bat
```

**Linux / Mac:**
```bash
make dev
```

---

### Ссылки

| Сервис        | URL                            |
|---------------|--------------------------------|
| 🌐 Сайт       | http://localhost               |
| 🔧 Админ      | http://localhost/admin         |
| 🗄️ phpMyAdmin  | http://localhost:8080          |
| 📧 Mailpit    | http://localhost:8025          |

---

### Обновление (после изменений в коде)

```bash
docker compose exec app php artisan project:update
npm run build   # только если менялся JS/CSS
```

---

### Продакшн

```env
APP_ENV=production
APP_DEBUG=false
```

```bash
make install
npm run build
```

---

### Все команды

```bash
make install      # установка с нуля
make dev          # запуск dev окружения (контейнеры + Vite)
make up           # запустить контейнеры
make down         # остановить контейнеры
make shell        # войти в контейнер
make migrate      # запустить миграции
make fresh        # migrate:fresh --seed
make test         # запустить тесты
make cache-clear  # очистить кеш
make npm-build    # собрать фронтенд
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

Сайт: http://127.0.0.1:8000
Админка: http://127.0.0.1:8000/admin

---

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

---

## Artisan команды

```bash
php artisan project:init      # Инициализация (migrate:fresh + seed + shield)
php artisan project:update    # Обновление (migrate + shield)
php artisan project:cache     # Пересобрать кеш
composer check                # pint + tests + phpstan
```

---

## Зависимости

| Пакет | Описание |
|-------|----------|
| filament/filament | Админ-панель |
| bezhansalleh/filament-shield | Роли и права |
| jeffgreco13/filament-breezy | Профиль пользователя |
| jacobtims/filament-logger | Логирование |
| spatie/laravel-translatable | Мультиязычность |
| abdulmajeed-jamaan/filament-translatable-tabs | Табы для переводов |
