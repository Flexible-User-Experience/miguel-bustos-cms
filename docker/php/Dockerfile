FROM php:8.4-apache

# Set server name
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Install system dependencies
RUN apt-get update && apt-get install -qq -y --no-install-recommends \
    nmap \
    cron \
    sqlite3 \
    vim \
    locales \
    coreutils \
    apt-utils \
    git \
    libicu-dev \
    g++ \
    libsqlite3-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libwebp-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    libxslt-dev \
    && rm -rf /var/lib/apt/lists/*

# Generate locales
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "es_ES.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

# Enable Apache modules
RUN a2enmod rewrite headers ssl

# Install Composer
RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer

# Configure and install PHP extensions
RUN docker-php-ext-configure intl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    docker-php-ext-install \
        pdo \
        pdo_sqlite \
        pdo_mysql \
        mysqli \
        gd \
        opcache \
        intl \
        zip \
        calendar \
        dom \
        mbstring \
        xsl

# Install and enable APCu
RUN pecl install apcu && docker-php-ext-enable apcu

# Set working directory and copy project
COPY ./ /var/www/project
WORKDIR /var/www/project

# Expose HTTP and HTTPS ports
EXPOSE 80
EXPOSE 443
