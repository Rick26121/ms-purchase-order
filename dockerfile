# Crear Dockerfile línea por línea
echo FROM php:8.2-fpm > Dockerfile
echo. >> Dockerfile
echo RUN apt-get update ^&^& apt-get install -y ^ >> Dockerfile
echo     git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev ^ >> Dockerfile
echo     libfreetype6-dev libjpeg62-turbo-dev npm nodejs libicu-dev ^^ ^ >> Dockerfile
echo     ^&^& docker-php-ext-configure gd --with-freetype --with-jpeg ^ >> Dockerfile
echo     ^&^& docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl soap xml >> Dockerfile
echo. >> Dockerfile
echo COPY --from=composer:latest /usr/bin/composer /usr/bin/composer >> Dockerfile
echo WORKDIR /var/www/html >> Dockerfile
echo. >> Dockerfile
echo COPY composer.json composer.lock ./ >> Dockerfile
echo RUN composer install --no-interaction --optimize-autoloader --no-dev --no-scripts >> Dockerfile
echo. >> Dockerfile
echo COPY . . >> Dockerfile
echo RUN npm install ^&^& npm run build ^|^| true >> Dockerfile
echo. >> Dockerfile
echo RUN chown -R www-data:www-data storage bootstrap/cache ^&^& chmod -R 775 storage bootstrap/cache >> Dockerfile
echo RUN php artisan config:cache ^&^& php artisan route:cache ^&^& php artisan view:cache ^|^| true >> Dockerfile
echo. >> Dockerfile
echo EXPOSE 9000 >> Dockerfile
echo CMD ["php-fpm"] >> Dockerfile