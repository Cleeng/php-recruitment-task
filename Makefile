.PHONY: up test down sh

up:
	docker compose up -d --build --wait
	docker compose exec app composer install --no-interaction
	docker compose exec app php bin/console doctrine:migrations:migrate --no-interaction
	docker compose exec app php bin/console doctrine:fixtures:load --no-interaction

test:
	docker compose exec app php bin/console --env=test doctrine:database:create --if-not-exists
	docker compose exec app php bin/console --env=test doctrine:migrations:migrate --no-interaction
	docker compose exec app php bin/console --env=test doctrine:fixtures:load --no-interaction
	docker compose exec app vendor/bin/phpunit

down:
	docker compose down -v

sh:
	docker compose exec app bash
