# 🚀 最新版のPHP 8.4 を使用
FROM php:8.4-cli

# システム依存パッケージのインストール
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Laravelの依存パッケージをインストール
RUN composer install --optimize-autoloader --no-dev

# パーミッション設定
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# 🚀 【重要】ここが決定版！CMDを書き換える
# Laravel11の起動と、CSS/JSの配置を正確に行います
CMD npm install && npm run build && php artisan migrate --force && php -S 0.0.0.0:${PORT:-80} -t public