test:
	./vendor/bin/phpunit

coverage:
	./vendor/bin/phpunit --coverage-html build/coverage
