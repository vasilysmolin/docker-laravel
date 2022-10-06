setup-ci: env-prepare install-ci key-ci database-prepare-ci

setup: env-prepare build install key database-prepare storage-link

test-coverage-ci:
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml

install-ci:
	composer install

key-ci:
	php artisan key:gen --ansi
	php artisan jwt:secret --force

database-prepare-ci:
	php artisan migrate:fresh --seed --force

lint-ci:
	composer exec phpcs -v

lint-fix-ci:
	composer exec phpcbf -v

phpstan-ci:
	composer exec phpstan analyse

analyse-ci:
	composer exec phpstan analyse -v

config-clear-ci:
	php artisan config:clear

test-coverage:
	docker-compose exec php composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml

lint:
	docker-compose exec php composer exec phpcs -v

lint-fix:
	docker-compose exec php composer exec phpcbf -v

phpstan:
	docker-compose exec php composer exec phpstan analyse

analyse:
	docker-compose exec php composer exec phpstan analyse -v

config-clear:
	docker-compose exec php php artisan config:clear

ide-helper:
	php artisan ide-helper:eloquent
	php artisan ide-helper:gen
	php artisan ide-helper:meta
	php artisan ide-helper:mod -n

update:
	git pull
	docker-compose exec php composer install
	docker-compose exec php php artisan migrate --force
	docker-compose exec php php artisan optimize

seeder:
	docker-compose exec php php artisan db:seed

env-prepare:
	cp -n .env.example .env || true

build:
	docker-compose up -d --build

install:
	docker-compose exec php composer install

key:
	docker-compose exec php php artisan key:gen --ansi
	docker-compose exec php php artisan jwt:secret --force

database-prepare:
	docker-compose exec php php artisan migrate:fresh --seed

storage-link:
	docker-compose exec php php artisan storage:link

heroku-build:
	composer install
	php artisan migrate --force
	php artisan db:seed --force
	php artisan optimize
	php artisan parse-vk-users

db-import-from-backup:
	docker-compose exec -T database psql -d tapigo-database -U postgres  < data
