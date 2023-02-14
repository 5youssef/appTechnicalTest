## How to Install and Run the Project

1. ```git clone https://github.com/5youssef/appTechnicalTest.git```
2. ```cd src```
3. ```composer install```
3. ```npm install```
4.  ```npm run dev```
5.  ```cd ..```
6. ```docker-compose build```
7. ```docker compose up -d```
8. You can see the project on ```127.0.0.1:8080```



## How to run Laravel Commands with Docker Compose

1. ```cd src```
2. ```docker-compose exec app php artisan {your command}``` 

3. add seeder to database ```docker-compose exec app php artisan db:seed``` 