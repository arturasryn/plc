## Run App With Makefile

- `make` : build docker and start all docker container with laravel setup + database migration and seeder
- `enter-php` : exec docker php container


## Run App Manually

- Create .env file for laravel environment from .env.example on src folder
- Run command ```docker-compose build``` on your terminal
- Run command ```docker-compose up -d``` on your terminal
- Run command ```docker exec php /bin/sh -c "composer install && chmod -R 777 storage && npm install && npm run build && php artisan key:generate && php artisan migrate:fresh --seed"`` on your terminal after went into php container on docker
- Go to http://localhost:8001


## Users

| email | password | 
| :---: | :---: |
| test1@example.com | password | 
| test2@example.com | password | 
| test3@example.com | password | 
| test4@example.com | password | 
| test5@example.com | password | 
| test6@example.com | password | 
| test7@example.com | password | 
| test8@example.com | password | 
| test9@example.com | password | 
| test10@example.com | password | 


## Preview

[screenshot-1]: images/1.png
[screenshot-2]: images/2.png
[screenshot-3]: images/3.png
[screenshot-4]: images/4.png


## ТЗ Backend

- Создать приложение,  которое будет самостоятельно  разворачиваться в докере (желательно). 
- Использовать Laravel framework 8.2+ 
- При развертывании должны автоматически создаться необходимые базы данных и наполняться  база данных тестовыми данными.

## Задача приложения: система учета задач с комментариями и статусами этих самых задач (небольшая Jira)

- Приложение должно иметь основные сущности: «Задача» и «Баг» 
- Приложение должно работать таким образом, чтобы данные из базы данных не удалялись, а только создавались или обновлялись. 
- У каждой «Задачи» или «Бага» должны быть общие методы, такие как «сменить статус», «добавить комментарий»
- Должна быть возможность менять “тип” сущности. 
- У сущностей существуют основные поля, которые обязательно должны иметь данные: «Название», «Содержание», «Создатель», -= - - «Тестировщик», «Исполнитель» и «Статус» 
- Доступные статусы: «пауза», «в работе», «тестирование» или «релиз» 
- Должна быть возможность добавлять, удалять данные сущности. 
- Реализовать «логирование» любых изменений данных сущностей в отдельной таблице базы данных. 
- Реализовать возможность добавлять комментарии к сущностям с поддержкой «ответ на комментарий» 
- Создать CRUD API для «сущностей» и «комментариев» к ней.
