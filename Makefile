start: # start a project
	docker-compose up -d

down: # down a project
	docker-compose down

restart: # restart a project
	docker-compose restart

composer-install: # install composer
	docker-compose exec php-bundle composer install

build: # project bootstrap
	docker-compose build
	docker-compose up -d
	cp www/.env.example www/.env
	docker-compose exec php-bundle composer install
	docker-compose exec php-bundle php artisan key:generate

tests:
	docker-compose exec php-bundle phpunit

