FROM php:8.2-fpm

# Установка библиотек и окружения
RUN apt-get update && apt-get install -y \
	libfreetype6-dev \
	libjpeg62-turbo-dev \
        libpng-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        libpq-dev \
        libheif-dev \
	libwebp-dev \
        zip \
        git \
        curl \
        unzip \
        npm \ 
    && npm install -g npm@8.19.3 \
    && curl -sL https://deb.nodesource.com/setup_18.x -o /tmp/nodesource_setup.sh \ 
    && bash /tmp/nodesource_setup.sh \
    && apt-get install -y nodejs \
    && docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-ext-install exif \
    && docker-php-ext-install pdo \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install soap \
    && docker-php-ext-install opcache \
    && docker-php-source delete \
    && pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

RUN docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install pcntl 

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копируем настройки OpCache
#COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Копируем данные
COPY --chown=www:www-data ./src /var/www/app

# Установка прав на папки
RUN chmod -R ug+w /var/www/app/storage && chown -R www-data:www-data /var/www/app/storage


# Рабочая директория
WORKDIR /var/www/app

COPY ./docker/start.sh /usr/local/bin/start
RUN chmod u+x /usr/local/bin/start && chown -R www-data:www-data /usr/local/bin/start

USER www-data

CMD ["/usr/local/bin/start"]