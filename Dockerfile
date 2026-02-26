# 1. PHPとNode.jsの両方が必要なので、マルチステージで行くか、Nodeをインストールします
FROM php:8.4-cli

# 必要なパッケージのインストール (Node.js 20を追加)
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip unzip git curl \
    && curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_mysql

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# 依存関係のインストール（PHP）
RUN composer install --no-dev --no-scripts --no-interaction --optimize-autoloader --ignore-platform-reqs

# ★追加：フロントエンドのビルド（CSS/JSを生成して manifest.json を作る）
RUN npm install
RUN npm run build

# 権限の設定
RUN chmod -R 777 storage bootstrap/cache

# 起動コマンド（マイグレーションをしてから起動）
CMD php artisan migrate --force && php -S 0.0.0.0:${PORT:-80} -t public