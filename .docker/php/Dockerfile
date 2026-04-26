FROM php:8.5-fpm-alpine AS base

WORKDIR /var/www/miguel-bustos/

ENV FPM_PM_MAX_CHILDREN="10" \
    PHP_OPCACHE_VALIDATE_TIMESTAMPS="1" \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="20000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="256" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10" \
    PHP_REALPATH_CACHE_TTL="120" \
    TZ="Europe/Madrid"

ARG PHPIZE_DEPS

RUN apk update                               && \
    apk add --no-cache --upgrade tini fcgi curl ;

RUN apk add --no-cache --virtual .build-deps    \
    $PHPIZE_DEPS                                \
    bash                                        \
    git                                         \
    tzdata                                      \
    icu-dev                                     \
    curl-dev                                    \
    oniguruma-dev                               \
    sqlite-dev                                  \
    libzip-dev                                  \
    libjpeg-turbo-dev                           \
    libpng-dev                                  \
    libwebp-dev                                 \
    libxml2-dev                                 \
    libxslt-dev                                 \
    linux-headers                               ;

RUN docker-php-ext-configure zip                                    && \
    docker-php-ext-configure gd --enable-gd --with-jpeg --with-webp && \
    docker-php-ext-install -j$(nproc)                                  \
    bcmath                                                             \
    curl                                                               \
    xml                                                                \
    mbstring                                                           \
    zip                                                                \
    pdo                                                                \
    pdo_sqlite                                                         \
    intl                                                               \
    xsl                                                                \
    gd                                                                 ;

RUN pecl install apcu-5.1.28 && \
    pecl clear-cache         && \
    docker-php-ext-enable apcu  ;

RUN { \
    EXT_DIR=$(php -r 'echo ini_get("extension_dir");');                                         \
    for ext in apcu bcmath curl xml mbstring zip pdo pdo_sqlite intl gd; do                     \
    test -f "$EXT_DIR/${ext}.so" || { echo "ERROR: ${ext}.so not found in $EXT_DIR"; exit 1; }; \
    done;                                                                                       \
    php -m | grep -q '^Zend OPcache$' || { echo "ERROR: Zend OPcache not loaded"; exit 1; };    \
};

COPY --from=composer/composer:2.9-bin /composer /usr/local/bin/composer

RUN deluser --remove-home www-data && \
    adduser -u1000 -D www-data        ;

FROM base AS development

RUN pecl install pcov-1.0.12 && \
    docker-php-ext-enable pcov  ;

RUN pecl install xdebug-3.5.0 && \
    docker-php-ext-enable xdebug ;

RUN mkdir -p /var/www/miguel-bustos/var/cache /var/www/miguel-bustos/var/log

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY .docker/php/php.ini-development "$PHP_INI_DIR/conf.d/90-custom.ini"
COPY .docker/php/xdebug-disabled.ini "$PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini"

RUN wget https://github.com/maglnet/ComposerRequireChecker/releases/download/4.19.0/composer-require-checker.phar && \
    chmod +x composer-require-checker.phar                                                                        && \
    mv composer-require-checker.phar /usr/local/bin/composer-require-checker                                         ;

RUN wget https://github.com/composer-unused/composer-unused/releases/download/0.9.5/composer-unused.phar && \
    chmod +x composer-unused.phar                                                                        && \
    mv composer-unused.phar /usr/local/bin/composer-unused                                                  ;

RUN wget https://github.com/overtrue/phplint/releases/download/9.7.1/phplint.phar && \
    chmod +x phplint.phar                                                         && \
    mv phplint.phar /usr/local/bin/phplint                                           ;

##############
# PROD stage #
##############
FROM base AS prod

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV APP_ENV=prod
ENV PHP_MEMORY_LIMIT="2G"
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0"
ENV FPM_PM_MAX_CHILDREN=80 \
    FPM_PM_START_SERVERS=20 \
    FPM_PM_MIN_SPARE_SERVERS=20 \
    FPM_PM_MAX_SPARE_SERVERS=60 \
    FPM_PM_MAX_REQUESTS=100

# https://github.com/docker-library/wordpress/blob/master/latest/php8.0/fpm-alpine/Dockerfile
RUN rm -r /tmp/pear;                                                                                            \
    # - detect runtime dependencies of the installed extensions.                                                \
    out="$(php -r 'exit(0);')";                                                                                 \
    [ -z "$out" ]; err="$(php -r 'exit(0);' 3>&1 1>&2 2>&3)";                                                   \
    [ -z "$err" ]; extDir="$(php -r 'echo ini_get("extension_dir");')";                                         \
    [ -d "$extDir" ];                                                                                           \
    runDeps="$(                                                                                                 \
        scanelf --needed --nobanner --format '%n#p' --recursive "$extDir"                                       \
        | tr ',' '\n' | sort -u | awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
    )";                                                                                                         \
    # save runtime Deps in a virtual deps                                                                       \
    apk add --no-network --virtual .php-extensions-rundeps $runDeps;                                            \
    # uninstall everything we've installed (minus the runtime Deps)                                             \
    apk del --no-network .build-deps;                                                                           \
    # check for output like "PHP Warning:  PHP Startup: Unable to load dynamic library 'foo' (tried: ...)       \
    err="$(php --version 3>&1 1>&2 2>&3)"; [ -z "$err" ]

# PHP config
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY --chown=www-data:www-data --link .docker/php/php.ini-production "$PHP_INI_DIR/conf.d/90-custom.ini"

# PHP-FPM config
RUN rm /usr/local/etc/php-fpm.d/*
COPY --chown=www-data:www-data --link .docker/php/php-fpm.d /usr/local/etc/php-fpm.d

# Healthcheck
COPY --chown=www-data:www-data --link .docker/php/php-fpm-healthcheck /usr/local/bin
RUN chmod +x /usr/local/bin/php-fpm-healthcheck

USER www-data

HEALTHCHECK CMD ["php-fpm-healthcheck"]

CMD ["php-fpm", "-F"]
