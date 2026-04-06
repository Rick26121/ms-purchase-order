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

# Copiar todo el código primero
COPY . .

# Crear directorios necesarios y dar permisos ANTES de composer install
RUN mkdir -p bootstrap/cache storage/framework/{cache,sessions,testing,views} storage/logs && \
    chmod -R 777 bootstrap/cache storage

# Instalar dependencias (deshabilitando scripts que requieren artisan)
RUN composer install --no-interaction --optimize-autoloader --no-dev --ignore-platform-reqs --no-scripts

# Ejecutar scripts después de que todo esté listo
RUN composer run-script post-autoload-dump --no-interaction || true

# Instalar dependencias Node y compilar assets
RUN npm install && npm run build || true

# Asegurar permisos finales
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]