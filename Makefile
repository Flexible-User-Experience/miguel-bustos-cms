.DEFAULT_GOAL := help

PHP_CONTAINER_NAME := "miguel-bustos-php"
NGINX_CONTAINER_NAME := "miguel-bustos-nginx"

hosts_file := "/etc/hosts"
hosts_line := "127.0.0.1 miguel-bustos.test"

# App
app/super-admin-password:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console app:user:change-password super_admin 12345678"

# PHP
php/lint:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "phplint --configuration=.phplint.yml"

# Composer
composer/install:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "composer install"

composer/update:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "composer update"

composer/recipes-update:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "composer recipe:update"

composer/execute-autoscripts:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "composer run-script auto-scripts"

composer/validate:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "composer validate --strict"

composer/outdated:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "composer outdated --minor-only --direct --strict"

composer/require-checker:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "composer-require-checker --ignore-parse-errors"

composer/unused:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "composer-unused"

# Xdebug
xdebug/enable:
	@docker exec --user root $(PHP_CONTAINER_NAME) sh -c "cp .docker/php/xdebug-enabled.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"
	@docker restart $(PHP_CONTAINER_NAME)
	@docker restart $(NGINX_CONTAINER_NAME)

xdebug/disable:
	@docker exec --user root $(PHP_CONTAINER_NAME) sh -c "cp .docker/php/xdebug-disabled.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"
	@docker restart $(PHP_CONTAINER_NAME)
	@docker restart $(NGINX_CONTAINER_NAME)

# Symfony
symfony/cache-clear:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console cache:clear"

symfony-test/cache-clear:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console cache:clear --env=test"

symfony/lint-container:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console lint:container"

symfony/lint-yaml:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console lint:yaml config src"

symfony/lint-twig:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console lint:twig templates"

symfony/messenger-consume:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console messenger:consume async -vv"

symfony/messenger-stop:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console messenger:stop-workers"

code-style/fix:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose"

code-style/fix-file:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose"

# Doctrine
doctrine/migration-status:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console doctrine:migrations:status"

doctrine/migration-generate:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console doctrine:migrations:diff"

doctrine/migration-execute:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console doctrine:migrations:migrate --no-interaction"

doctrine/schema-validate:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console doctrine:schema:validate --skip-sync"

doctrine/db-drop:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console doctrine:database:drop --force --if-exists"

doctrine/db-create:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console doctrine:database:create --if-not-exists"

doctrine/db-create-schema:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console doctrine:schema:create --quiet"

doctrine/db-fixtures: doctrine/db-recreate
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console hautelook:fixtures:load --no-interaction"

doctrine/db-recreate: \
	doctrine/db-drop \
	doctrine/db-create \
	doctrine/db-create-schema

# Doctrine test db
doctrine-test/db-drop:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console doctrine:database:drop --force --env=test"

doctrine-test/db-create:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console doctrine:database:create --env=test"

doctrine-test/db-create-schema:
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console doctrine:schema:create --quiet --env=test"

doctrine-test/db-fixtures: doctrine-test/db-recreate
	@docker exec $(PHP_CONTAINER_NAME) sh -c "bin/console hautelook:fixtures:load --no-interaction --env=test"

doctrine-test/db-recreate: \
	doctrine-test/db-drop \
	doctrine-test/db-create \
	doctrine-test/db-create-schema

# Test
test/controller: doctrine-test/db-fixtures symfony-test/cache-clear
	@docker exec $(PHP_CONTAINER_NAME) sh -c "vendor/bin/phpunit"

test: test/controller

# Local
local-server/hosts-line:
	grep -qF $(hosts_line) $(hosts_file) || echo $(hosts_line) | sudo tee -a $(hosts_file)

local-server/login-info:
	$(info **********************************)
	$(info Local server is running)
	$(info URL: https://miguel-bustos.test:44301)
	$(info Admin URL: https://miguel-bustos.test:44301/admin/login)
	$(info User: super_admin@email.com)
	$(info Password: 12345678)
	$(info **********************************)

git/install-hooks:
	ln -sf ../../scripts/githooks/pre-commit .git/hooks/pre-commit

install: \
	rebuild \
	xdebug/disable \
	composer/install \
	symfony/cache-clear \
	doctrine/db-fixtures \
	doctrine-test/db-recreate \
	app/super-admin-password \
	git/install-hooks \
	local-server/hosts-line \
	local-server/login-info

it: \
	test/controller \
	composer/validate \
	composer/require-checker \
	doctrine/schema-validate \
	php/lint \
	symfony/lint-container \
	symfony/lint-yaml \
	symfony/lint-twig

# Docker
start: CMD=up
startd: CMD=up -d
stop: CMD=stop
destroy: CMD=down

start startd stop destroy:
	@docker compose $(CMD)

rebuild:
	make destroy
	COMPOSE_BAKE=true docker compose build --pull --force-rm --no-cache
	make startd

restart: stop start

restartd: stop startd

bash:
	@docker exec -it $(PHP_CONTAINER_NAME) bash
