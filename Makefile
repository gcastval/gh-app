
env ?= dev

ifeq ($(OS),Windows_NT)
DIR_SEPARATOR=\\
VENDOR_DIR=.\\vendor\\bin\\
else
DIR_SEPARATOR=/
endif


start:
	docker compose -f docker-compose.test.yml up --build -d

test:
	@echo "waiting for db to be available..."

	@bash -c ' \
	while ! $(MAKE) ping-database; do \
		echo "Waiting..."; \
		sleep 2; \
	done; \
	'

	@echo "db is available"

	$(MAKE) setup-docker-test-db
	docker exec app php bin/phpunit

	$(MAKE) docker-test-stop


docker-test-stop:
	docker-compose -f docker-compose.test.yml down

setup-docker-test-db:
	docker exec app make create-database env=test
	docker exec app make migrate-database env=test

create-database:
	php bin/console doctrine:database:create --if-not-exists --env=${env}

migrate-database:
	php bin/console doctrine:migration:migrate --env=${env}

migration:
	php bin/console make:migration

ping-database:
	docker exec db mysqladmin ping -h db -P 3306 --silent

lint-check:
	docker exec app vendor/bin/php-cs-fixer fix src --dry-run --diff

lint-fix:
	docker exec app vendor/bin/php-cs-fixer fix src