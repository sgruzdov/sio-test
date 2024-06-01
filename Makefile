USER_ID=$(shell id -u)

DC = @USER_ID=$(USER_ID) docker compose
DC_RUN = ${DC} run --rm php-sio-test
DC_EXEC = ${DC} exec -it php-sio-test

PHONY: help
.DEFAULT_GOAL := help

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

init: down build install up success-message console ## Initialize environment

build: ## Build services.
	${DC} build $(c)

up: ## Create and start services.
	${DC} up -d $(c)

stop: ## Stop services.
	${DC} stop $(c)

start: ## Start services.
	${DC} start $(c)

down: ## Stop and remove containers and volumes.
	${DC} down -v $(c)

restart: stop start ## Restart services.

console: ## Login in console.
	${DC_EXEC} sh

install:
	${DC_RUN} php composer.phar install

init-db: apply-migrations apply-fixtures ## Initialize DB structure

apply-migrations: ## Apply basic structure
	${DC_RUN} php bin/console --no-interaction doctrine:migrations:migrate

apply-fixtures: ## Apply fixtures
	${DC_RUN} php bin/console doctrine:fixtures:load

init-test-env: ## Initialize db for unit testing
	${DC_RUN} sh before-test.sh

success-message:
	@echo "You can now access the application at http://localhost:8337"
	@echo "Good luck! 🚀"