FROM php:8.4-fpm

COPY --from=composer:2.8.9 /usr/bin/composer /usr/bin/composer

ARG APP_USER_ID
ARG APP_USER_NAME

RUN apt-get update \
&&  apt-get install -y --no-install-recommends \
      libicu-dev \
      libzip-dev \
      unzip \
\
&&  docker-php-ext-install -j$(nproc) \
      intl \
      zip \
\
&&  apt-get clean \
&&  rm -rf /var/lib/apt/lists/* \
\
&&  adduser ${APP_USER_NAME} --disabled-password --uid ${APP_USER_ID} --gecos "" --shell /sbin/nologin

RUN pecl install xdebug \
&&  docker-php-ext-enable xdebug

USER ${APP_USER_NAME}

WORKDIR /var/www/elasticsearch-fluent-query-builder/src
