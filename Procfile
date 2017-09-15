web: $(composer config bin-dir)/heroku-php-nginx -C nginx.conf public/
worker: php artisan queue:listen --tries=10 --delay=20
