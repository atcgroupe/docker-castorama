FROM php:8.1-cli

RUN curl https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash && \
    apt update && apt install -y zip libzip-dev git libicu-dev symfony-cli locales && \
    echo "fr_FR.UTF-8 UTF-8" > /etc/locale.gen && locale-gen && \
    docker-php-ext-install opcache intl pdo_mysql zip && \
    symfony server:ca:install

WORKDIR /app

COPY composer.json .
COPY php.ini-dev ${PHP_INI_DIR}/php.ini

RUN composer install

COPY . .

CMD ["symfony", "serve"]
