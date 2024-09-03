FROM php:8.3-fpm

WORKDIR /var/www/html
USER root

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    npm \
    nodejs \
    libpq-dev

RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader --no-dev --no-ansi --no-interaction --no-plugins --no-progress

COPY package.json package-lock.json ./
RUN npm install

COPY . .

RUN npm audit fix \
    && npm run build

RUN composer dump-autoload --optimize


COPY Docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
