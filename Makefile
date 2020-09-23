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
	cp .env.example .env
	docker-compose exec php-bundle composer install

tests:
	docker-compose exec php-bundle phpunit

