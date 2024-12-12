### Contents
```text
PHP
Composer
Docker
MySQl
Redis
Jwt
Nginx
Testing
Rate limiting
```
### Installation
```shell
docker compose up -d --build 
docker compose exec app bash
chmod -R 777 /var/www/html/storage/ /var/www/html/bootstrap/
cp .env.example .env
composer install
docker compose exec app php artisan jwt:secret
docker compose exec app php artisan migrate:fresh --seed
```
### env config
- mysql
```text
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=laravel
```
- redis
```text
CACHE_DRIVER=redis
REDIS_CLIENT=predis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```
### Usage
```text
Insomnia_2024-12-13.json
```

### Testing
```shell
cp .env .env.testing
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan migrate:fresh --seed --env=testing
docker-compose exec app php artisan test
```
- env.testing
```text
APP_ENV=testing
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=laravel
```
