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