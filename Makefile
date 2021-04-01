ci:
	vendor/bin/phpunit --color=always --testsuite unit-tests
	vendor/bin/phpstan analyse -c vendor/landingi/php-coding-standards/phpstan.neon --memory-limit=256M
	vendor/bin/ecs check --config vendor/landingi/php-coding-standards/ecs.php
fix:
	vendor/bin/ecs check --fix --config vendor/landingi/php-coding-standards/ecs.php
test:
	vendor/bin/phpunit --color=always --testsuite unit-tests
	vendor/bin/phpunit --color=always --testsuite functional-tests
unit:
	vendor/bin/phpunit --color=always --testsuite unit-tests
functional:
	vendor/bin/phpunit --color=always --testsuite functional-tests
coverage:
	vendor/bin/phpunit --coverage-text
coverage-html:
	vendor/bin/phpunit --coverage-html=build/coverage/
analyse:
	vendor/bin/phpstan analyse -c vendor/landingi/php-coding-standards/phpstan.neon --memory-limit=256M
	vendor/bin/ecs check --config vendor/landingi/php-coding-standards/ecs.php
code-quality:
	vendor/bin/phpunit --coverage-clover=build/coverage.xml
	vendor/bin/cqt quality:coverage-validate --coverage-clover-path=build/coverage.xml --crap-threshold=5
run:
	composer install --no-interaction --prefer-dist
	exec /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
