.PHONY: up down build restart shell shell-root logs migrate seed fresh test install dev

# Первый запуск — полная установка с нуля
install:
	cp -n .env.example .env
	docker compose up -d --build
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan project:init
	docker compose exec app php artisan make:filament-user
	@echo ""
	@echo "✅ Готово! Открывай: http://localhost/admin"

# Запуск dev окружения (если уже установлено)
dev:
	docker compose up -d
	docker compose exec app npm run dev

up:
	docker compose up -d

down:
	docker compose down

build:
	docker compose build --no-cache

restart:
	docker compose restart

shell:
	docker compose exec app sh

shell-root:
	docker compose exec -u root app sh

logs:
	docker compose logs -f

migrate:
	docker compose exec app php artisan migrate

seed:
	docker compose exec app php artisan db:seed

fresh:
	docker compose exec app php artisan migrate:fresh --seed

test:
	docker compose exec app php artisan test

cache-clear:
	docker compose exec app php artisan optimize:clear

composer-install:
	docker compose exec app composer install

npm-dev:
	npm run dev
