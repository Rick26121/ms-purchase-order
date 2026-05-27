FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev \
    libfreetype6-dev libjpeg62-turbo-dev npm nodejs libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    soap \
    xml

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Crear directorios de cache ANTES de cualquier cosa
RUN mkdir -p bootstrap/cache \
    && mkdir -p storage/framework/cache \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/framework/testing \
    && mkdir -p storage/logs \
    && chmod -R 777 bootstrap/cache storage

# Copiar archivos de composer primero (mejor caché)
COPY composer.json composer.lock ./

# Instalar dependencias de composer (sin scripts de Laravel)
RUN composer install --no-interaction --ignore-platform-reqs --no-scripts

# Ahora copiar todo el resto del código
COPY . .

# Ejecutar scripts de Laravel después de tener el código
RUN php artisan package:discover --ansi || true

RUN npm install && npm run build || true

# Permisos finales
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000
RUN php artisan view:clear || true
RUN php artisan config:clear || true
RUN php artisan cache:clear || true

CMD ["php-fpm"]