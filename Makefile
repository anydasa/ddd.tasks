include .env
export

ARGS = $(filter-out $@,$(MAKECMDGOALS))

.PHONY: fix-permission
fix-permission: ## fix permission for docker env
	sudo chown -R $(shell whoami):$(shell whoami) .
	sudo chmod +x ./bin/console

.PHONY: app-cache-clear
app-cache-clear: ## clear cache in for application
	docker-compose exec php sh -lc 'bin/console cache:clear'

.PHONY: code-analyse
code-analyse: ## analise code
	docker-compose exec php sh -lc 'vendor/bin/phpstan analyse'
	docker-compose exec php sh -lc '/usr/local/bin/deptrac'
	docker-compose exec php sh -lc 'vendor/bin/ecs check'

.PHONY: code-fix
code-fix: ## fix code
	docker-compose exec php sh -lc 'vendor/bin/ecs check --fix'

.PHONY: test
test: ## execute tests
	docker-compose -f docker-compose.test.yml up -d
	docker-compose -f docker-compose.test.yml exec php-test sh -lc 'vendor/bin/behat features/api/form/ --no-snippets'
	docker-compose -f docker-compose.test.yml down -v

.PHONY: help
help: ## Display this help message
	@cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
