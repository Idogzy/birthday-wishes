FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    sqlite3 \
    && docker-php-ext-install pdo_pgsql pdo_sqlite \
    && apt-get clean

COPY . /app
WORKDIR /app

EXPOSE 10000

CMD php -S 0.0.0.0:$PORT -t .
