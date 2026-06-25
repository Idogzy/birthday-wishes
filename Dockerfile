FROM php:8.2-cli

# pdo_sqlite is built-in, only need pdo_pgsql for Render PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && apt-get clean

COPY . /app
WORKDIR /app

EXPOSE 10000

CMD php -S 0.0.0.0:$PORT -t .
