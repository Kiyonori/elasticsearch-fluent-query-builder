CONTAINER_NAME=php
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
	docker compose exec -it $(CONTAINER_NAME) ./vendor/bin/pest $(filter-out $@,$(MAKECMDGOALS))

pest:
	docker compose exec -it $(CONTAINER_NAME) ./vendor/bin/pest $(filter-out $@,$(MAKECMDGOALS))

%:
	@:
