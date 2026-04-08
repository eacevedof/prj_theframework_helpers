help: ## Show this help message
	@echo "usage: make [target]"
	@echo
	@echo "targets:"
	@egrep "^(.+)\:\ ##\ (.+)" ${MAKEFILE_LIST} | column -t -c 2 -s ":#"

gitpush: ## git push m=any message
	clear;
	git add .; git commit -m "$(m)"; git push;

server: ## localhost:3000
	php -S localhost:3000 -t ./public

CURRENT_BRANCH := $(shell git rev-parse --abbrev-ref HEAD)
update-branch:  ## update main branches
	git fetch --all;

	git checkout master; git reset --hard origin/master;
	git checkout develop; git reset --hard origin/develop;

	git checkout $(CURRENT_BRANCH);

# =============================================================================
# Tests
# =============================================================================

test: ## Run all tests
	./vendor/bin/phpunit

test-helpers: ## Run only helpers tests
	./vendor/bin/phpunit --testsuite Helpers

test-components: ## Run only components tests
	./vendor/bin/phpunit --testsuite Components

test-coverage: ## Run tests with coverage report
	./vendor/bin/phpunit --coverage-html coverage

test-filter: ## Run filtered tests (make test-filter f=testName)
	./vendor/bin/phpunit --filter $(f)

test-verbose: ## Run tests with verbose output
	./vendor/bin/phpunit -v

# =============================================================================
# Development
# =============================================================================

install: ## Install composer dependencies
	composer install

autoload: ## Regenerate autoload files
	composer dump-autoload -o

lint: ## Check PHP syntax errors
	@find packages -name "*.php" -exec php -l {} \; 2>&1 | grep -v "No syntax errors" || echo "All files OK"