
env ?= dev

test:
	php bin/phpunit

create-database:
	php bin/console doctrine:database:create --if-not-exists --env=${env}

migrate-database:
	php bin/console doctrine:migration:migrate --env=${env}

migration:
	php bin/console make:migration