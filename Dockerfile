FROM php:8.4-apache

# 必要なパッケージのインストール
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# (前半のパッケージインストールなどはそのまま)

# 1. 重複の原因となる MPM 設定を一度すべて無効化し、'prefork' だけを強制的に有効にする
RUN a2dismod mpm_event mpm_worker || true && a2enmod mpm_prefork

# 2. mod_rewrite を有効化
RUN a2enmod rewrite

# 3. Apacheの設定（ドキュメントルートの変更）
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# アプリケーションファイルのコピー
WORKDIR /var/www/html
COPY . .

# 依存関係のインストール
RUN composer install --no-dev --no-scripts --no-interaction --optimize-autoloader --ignore-platform-reqs

# 権限の設定
RUN chown -R www-data:www-data storage bootstrap/cache

# ★ここが重要：CMDもENTRYPOINTも書かない（ベースイメージに任せる）
EXPOSE 80