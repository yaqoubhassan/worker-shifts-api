# worker-shifts-api

## Project Setup

Create a MySQL database and name it "worker_shift_api"

Create a .env file in the root project, copy and paste the content of .env.example into .env, or simply run the command "cp .env.example .env"

## Run the following commands

```sh
composer install
```

```sh
php artisan key:generate
```

```sh
php artisan migrate
```

```sh
php artisan serve
```
