ENV?=dev

# ====================
# Qualimetry rules

## Run all qualimetry tasks
qualimetry: lint checkstyle

## Qualimetry : lint
lint:
	find -L src -name '*.php' -print0 | xargs -0 -n 1 -P 4 php -l

## Qualimetry : checkstyle
cs: checkstyle
checkstyle:
	vendor/bin/phpcs --extensions=php -n --standard=PSR2 --report=full src

