run:
	cp ./src/.env.example ./src/.env
	docker compose build
	docker compose up -d
	docker exec php /bin/sh -c "composer install --optimize-autoloader && chmod -R 777 storage && npm install && npm run build && php artisan key:generate && php artisan config:cache && php artisan route:cache && php artisan key:generate && php artisan view:cache && php artisan key:generate && php artisan route:cache && php artisan migrate:fresh --seed --force"

enter-php:
	docker exec -it php /bin/sh