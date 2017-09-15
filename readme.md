
## Heroku Laravel Example

This is boilerplate Laravel 5.5 project similar to what the `laravel new`, `composer create-project` commands create.

This project can be used as is as a shortcut to deploying Laravel 5.5 on heroku, or used as a guide.

## Heroku Specific Configurations

- Procfile defining a web process using nginx and a worker process for running queues
- Database configuration defaults to use Postgres using heroku-postgres `DATABASE_URL` environment variable
- Redis configuration setup to use heroku-redis `REDIS_URL` environment variable
- Failed job database configuration defaults to postgres
- Laravel 5.5 TrustedProxy middleware configured to trust Heroku load balancers correctly  

## Local Development

**1. Database, app key, .env**

Clone this repository and run the following commands:

```sh
cp .env.example .env
composer install
php artisan key:generate
touch database/database.sqlite
php artisan migrate
```

**2. Run**

```sh
php artisan serve
```

## Deploying to Heroku

**1. Create a Heroku App**

Setup an app name

```sh
app_name=heroku-laravel55-test-app
```

Create a heroku app

```sh
heroku apps:create $app_name
heroku addons:create heroku-postgresql:hobby-dev --app $app_name
heroku addons:create heroku-redis:hobby-dev --app $app_name
```

**2. Add Heroku git remote**

```sh
heroku git:remote --app $app_name
```

**3. Set config parameters**

To operate correctly you need to set `APP_KEY`:

```sh
heroku config:set APP_KEY=$(php artisan --no-ansi key:generate --show)
heroku config:set APP_LOG=errorlog 
```

Configure additional parameters to utilise redis

```sh
heroku config:set QUEUE_DRIVER=redis SESSION_DRIVER=redis CACHE_DRIVER=redis
```

Optionally set your app's environment to development

```sh
heroku config:set APP_ENV=development APP_DEBUG=true APP_LOG_LEVEL=debug
```

**4. Deploy to Heroku**

```sh
 git push heroku master
```

---

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
