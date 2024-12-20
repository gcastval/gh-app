
env ?= dev


test-ci:
	$(MAKE) docker-test-start 

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


docker-test-start:
	docker-compose -f docker-compose.test.yml up --build -d

docker-test-stop:
	docker-compose -f docker-compose.test.yml down

setup-docker-test-db:
	docker exec app make create-database env=test
	docker exec app make migrate-database env=test

test:
	php bin/phpunit

create-database:
	php bin/console doctrine:database:create --if-not-exists --env=${env}

migrate-database:
	php bin/console doctrine:migration:migrate --env=${env}

migration:
	php bin/console make:migration

ping-database:
	docker exec db mysqladmin ping -h db -P 3306 --silent