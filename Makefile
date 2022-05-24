dockerComposeDirectory = "./docker"

init: down \
	build \
	up \
	composer-install \
	npm-install \
	npm-build

restart: down up

build:
	@cd $(dockerComposeDirectory) && \
	docker-compose build

up:
	@cd $(dockerComposeDirectory) && \
	docker-compose up -d

down:
	@cd $(dockerComposeDirectory) && \
	docker-compose down

ps:
	@cd $(dockerComposeDirectory) && \
	docker-compose ps

bash:
	@cd $(dockerComposeDirectory) && \
	docker-compose run --rm preview-php-cli bash

composer-install:
	@cd $(dockerComposeDirectory) && \
	docker-compose run --rm preview-php-cli composer install

npm-cli:
	@cd $(dockerComposeDirectory) && \
	docker-compose run --rm preview-node-cli bash

npm-install:
	@cd $(dockerComposeDirectory) && \
	docker-compose run --rm preview-node-cli npm install

npm-build:
	@cd $(dockerComposeDirectory) && \
	docker-compose run --rm preview-node-cli npm run build

npm-watch:
	@cd $(dockerComposeDirectory) && \
	docker-compose run --rm preview-node-cli npm run watch

ssh:
	@cd $(dockerComposeDirectory) && \
	docker-compose run --rm --name=preview-ssh-server preview-ssh-server bash