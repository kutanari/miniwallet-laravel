setup:
	docker-compose up -d

setup-verbose:
	docker-compose up

destroy:
	docker-compose down

migrate:
	docker-compose exec miniwalletapp php artisan migrate