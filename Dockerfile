FROM php:8.4-cli-alpine

WORKDIR /var/www/html

RUN apk add --no-cache \
  git \
  unzip \
  curl \
  libzip-dev \
  sqlite-libs \
  sqlite-dev \
  && docker-php-ext-install pdo pdo_sqlite zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY container/api/ .

COPY container/startup.sh /usr/local/bin/startup.sh

RUN chmod +x /usr/local/bin/startup.sh

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8000

ENTRYPOINT ["sh", "/usr/local/bin/startup.sh"]