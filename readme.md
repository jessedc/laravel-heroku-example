
## Heroku Laravel Example

This is boilerplate Laravel 5.6 project similar to what the `laravel new` or `composer create-project` commands create.

This project can be used as is as a shortcut to deploying a Laravel 5.6 app on heroku, or used as a guide.

## Heroku Specific Configuration

- [Procfile](https://devcenter.heroku.com/articles/procfile) defining a web process using nginx and a worker process for running queues
- Database configuration defaults set to use Postgres and to parse heroku-postgres `DATABASE_URL` environment variable
- Redis configuration setup to use heroku-redis `REDIS_URL` environment variable
- Failed job database configuration defaulting to postgres
- A heroku app.json and post-deployment script (`php artisan postdeploy:heroku`)for use with Heroku Review Apps
- TrustedProxies middleware configured to trust Heroku load balancers correctly
- npm task named "postinstall" that is run during heroku deployments
- Heroku specific logging configuration set as the default.  

## Additional Configuration

- Pinned to PHP 7.1 (`~7.1.0`)
- Setup with bootstrap scaffolding (`php artisan preset bootstrap`)

## Local Development

**1. Database, app key, .env**

Clone this repository and run the following commands:

```bash
composer install
cp .env.example .env
touch database/database.sqlite
php artisan key:generate
php artisan migrate
npm install 
npm run dev
```

**2. Run**

```bash
php artisan serve
```

## Deploying to Heroku

**1. Create a Heroku app**

Create an app name

```bash
app_name=heroku-laravel56-test-app
```

Create Heroku app

```bash
heroku apps:create $app_name
heroku addons:create heroku-postgresql:hobby-dev --app $app_name
heroku addons:create heroku-redis:hobby-dev --app $app_name
heroku buildpacks:add heroku/php --app $app_name
heroku buildpacks:add heroku/nodejs --app $app_name
```

**2. Add Heroku git remote**

```bash
heroku git:remote --app $app_name
```

**3. Set config parameters**

For Laravel to operate correctly you need to set `APP_KEY`:

```bash
heroku config:set --app $app_name APP_KEY=$(php artisan --no-ansi key:generate --show)
```

Set Queues, sessions and cache to use redis

```bash
heroku config:set --app $app_name QUEUE_DRIVER=redis SESSION_DRIVER=redis CACHE_DRIVER=redis
```

Optionally set your app's environment to development

```bash
heroku config:set --app $app_name APP_ENV=development APP_DEBUG=true APP_LOG_LEVEL=debug
```

**4. Deploy to Heroku**

```bash
 git push heroku master
```

**5. Run migrations**

```bash
heroku run -a $app_name php artisan postdeploy:heroku
```

---

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
