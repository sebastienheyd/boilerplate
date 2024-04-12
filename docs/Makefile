.PHONY:help start stop restart status logs rebuild pull remove
.DEFAULT_GOAL=help

CYAN   = \033[0;36m
NC     = \033[m

help:
	@grep -h -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

start: ## Start container port 8080
	@docker-compose up -d --remove-orphans

stop: ## Stop container
	@docker-compose down --remove-orphans

restart: stop start ## Restart container

pull: ## Pull latest version of Vuepress
	@docker-compose pull vuepress
	
remove: ## Remove container
	@docker-compose down --rmi all -v --remove-orphans

rebuild: stop ## Rebuild container
	@docker-compose build --no-cache --compress vuepress
	@docker-compose up -d --remove-orphans

status: ## Container status
	@docker-compose ps

logs: ## Container logs
	@docker-compose logs --follow vuepress

clean: ## Clean container volume content
	@sudo rm -rf node_modules yarn.lock