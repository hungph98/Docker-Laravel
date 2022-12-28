dir=${CURDIR}
dev=-f docker-compose.yml
app_container=base-php
app_mysql=base-mysql
app_supervisor=base-supervisor

build:
	docker-compose $(dev) build

start:
	docker-compose $(dev) $(project) up -d

stop:
	docker-compose $(dev) $(project) stop

ssh:
	docker exec -it --user=appuser $(app_container) bash

ssh-sql:
	docker exec -it --user=appuser $(app_mysql) bash

ssh-supervisord:
	docker exec -it --user=appuser $(app_supervisor) bash

composer-install:
	docker exec -u appuser $(app_container) composer install

key-gen:
	docker exec -u appuser $(app_container) php artisan key:generate

env:
	docker exec -u appuser $(app_container) cp .env.example .env
