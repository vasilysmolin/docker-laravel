test:
	docker-compose exec php php artisan test

migrate:
	docker-compose exec php php artisan migrate

autoload:
	docker-compose exec php composer install

test-coverage:
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml

lint:
	composer exec phpcs -v

lint-fix:
	composer exec phpcbf -v

phpstan:
	composer exec phpstan analyse

analyse:
	composer exec phpstan analyse -v

config-clear:
	php artisan config:clear

env-prepare:
	cp -n .env.example .env || true

key:
	php artisan key:generate

ide-helper:
	php artisan ide-helper:eloquent
	php artisan ide-helper:gen
	php artisan ide-helper:meta
	php artisan ide-helper:mod -n

update:
	git pull
	docker-compose exec php composer install --no-interaction --ansi --no-suggest
	docker-compose exec php php artisan migrate --force
	docker-compose exec php php artisan optimize

seeder:
	docker-compose exec php php artisan db:seed --class="Database\Seeders\FoodDishesCategorySeeder"
	docker-compose exec php php artisan db:seed --class="Database\Seeders\FoodCategoryRestaurantSeeder"
	docker-compose exec php php artisan db:seed --class="Database\Seeders\JobsCategoryResumeSeeder"
	docker-compose exec php php artisan db:seed --class="Database\Seeders\JobsCategoryVacancySeeder"
	docker-compose exec php php artisan db:seed --class="Database\Seeders\ServiceCategorySeeder"

seeder-dev:
	docker-compose exec php php artisan db:seed


heroku-build:
	php artisan migrate --force
	php artisan db:seed --force
	php artisan optimize

setup:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	php artisan migrate --force
	php artisan db:seed --force
	php artisan optimize

db-import-from-backup:
	docker-compose exec -T database psql -d tapigo-database -U postgres  < data
