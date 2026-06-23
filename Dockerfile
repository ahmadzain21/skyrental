FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip curl nodejs npm \
    libpng-dev libjpeg-dev libfreetype6-dev libzip-dev zip libpq-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install \
        gd zip pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN rm -f .env

# 🔥 INSTALL BACKEND
RUN composer install --no-dev --optimize-autoloader

# 🔥 INSTALL FRONTEND
RUN npm install
RUN npm run build

RUN chmod -R 775 storage bootstrap/cache

CMD php artisan storage:link || true; \
    php artisan config:clear; \
    php artisan cache:clear; \
    php artisan migrate --force; \
    php artisan db:seed --force || true; \
    php artisan config:cache; \
    php artisan serve --host=0.0.0.0 --port=$PORT