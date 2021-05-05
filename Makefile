.PHONY:help test cs csfix clean
.DEFAULT_GOAL=help

help:
	@grep -h -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

composer.phar:
	@curl -sS https://getcomposer.org/installer | php -- --filename=composer.phar
	@chmod +x composer.phar

vendor: composer.phar composer.json
	@./composer.phar install --prefer-source --no-interaction --optimize-autoloader

cs: vendor ## Check for coding standards
	@php vendor/bin/phpcs

csfix: vendor ## Check and fix for coding standards
	@php vendor/bin/phpcbf

test: vendor phpunit.xml ## Unit testing
	@php vendor/bin/phpunit --stop-on-failure

clean: ## Remove files needed for tests
	@rm -rf composer.phar composer.lock vendor testbench
