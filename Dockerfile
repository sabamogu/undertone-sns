# Apache版ではなく、軽量な CLI版を使う
FROM php:8.4-cli

# 必要なパッケージ（MySQL接続など）のインストール
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip unzip git \
    && docker-php-ext-install pdo pdo_mysql

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# 依存関係のインストール
RUN composer install --no-dev --no-scripts --no-interaction --optimize-autoloader --ignore-platform-reqs

# 権限の設定
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 777 storage bootstrap/cache

RUN php artisan migrate --force
CMD php artisan migrate --force && php -S 0.0.0.0:${PORT:-80} -t public