CONTAINER_NAME=php

# OS ごとに script を使い分ける
ifeq ($(shell uname -s),Darwin)
	PINT_SCRIPT = script /dev/null docker compose exec php ./vendor/bin/pint
else
	PINT_SCRIPT = script -q -c "docker compose exec php ./vendor/bin/pint" /dev/null
endif

.PHONY: up

up:
	@if [ ! -f ./.env ]; then \
		echo "Copying .env.example to .env"; \
		cp .env.example .env; \
	else \
		echo ".env already exists"; \
	fi

	docker compose build
	docker compose up -d

test:
	docker compose exec $(CONTAINER_NAME) ./vendor/bin/pest --colors=always $(filter-out $@,$(MAKECMDGOALS))

pest:
	docker compose exec $(CONTAINER_NAME) ./vendor/bin/pest --colors=always $(filter-out $@,$(MAKECMDGOALS))

pint:
	$(PINT_SCRIPT) $(filter-out $@,$(MAKECMDGOALS))

%:
	@:
