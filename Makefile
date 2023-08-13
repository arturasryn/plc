run:
	cp ./src/.env.example ./src/.env
	docker compose build
	docker compose up -d
	docker exec php /bin/sh -c "composer install && chmod -R 777 storage && npm install && npm run build && php artisan key:generate && php artisan migrate:fresh --seed"

enter-php:
	docker exec -it php /bin/sh