.PHONY:help cs csfix test testcoverage testcoveragehtml clean
.DEFAULT_GOAL=help

PHP?=php8.2

help:
	@grep -h -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

composer.phar:
	@curl -sS https://getcomposer.org/installer | $(PHP) -- --filename=composer.phar
	@chmod +x composer.phar

vendor: composer.phar composer.json
	@$(PHP) composer.phar install --no-interaction --optimize-autoloader

cs: vendor ## Check for coding standards
	@$(PHP) vendor/bin/phpcs

csfix: vendor ## Check and fix for coding standards
	@$(PHP) vendor/bin/phpcbf

test: vendor phpunit.xml ## Unit testing
	@$(PHP) vendor/bin/phpunit --stop-on-failure

testcoverage: composer.phar vendor phpunit.xml ## Unit testing with code coverage
	@XDEBUG_MODE=coverage $(PHP) vendor/bin/phpunit --coverage-text

testcoveragehtml: composer.phar vendor phpunit.xml ## Unit testing with code coverage in HTML
	@XDEBUG_MODE=coverage $(PHP) vendor/bin/phpunit --coverage-html coverage

clean: ## Remove files needed for tests
	@rm -rf composer.phar composer.lock vendor testbench coverage .phpunit.result.cache .phpunit.cache