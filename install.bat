@echo off
echo Installing project...

copy /Y .env.example .env

docker compose up -d --build

docker compose exec app composer install

call npm install

docker compose exec app php artisan key:generate

docker compose exec app php artisan project:init

docker compose exec app php artisan make:filament-user

echo.
echo Done! Open: http://localhost/admin
pause
