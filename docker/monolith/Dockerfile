# syntax=docker/dockerfile:1
# =============================================================================
# Container monolítico de desenvolvimento: Apache + PHP 8.4 + Node 24.
#
# Substitui os três serviços separados (nginx, app/php-fpm, vite) por um
# único container, permitindo rodar `npm run build` e `npm run dev`
# diretamente após entrar com `docker exec -it <container> bash`.
# =============================================================================

ARG PHP_VERSION=8.4
ARG NODE_VERSION=24

# Composer vem da imagem oficial — nunca de script baixado em runtime.
FROM composer:2 AS composer_bin

# =============================================================================
# app — Apache + PHP + Node (dev)
# =============================================================================
FROM php:${PHP_VERSION}-apache

ARG NODE_VERSION=24

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/tmp/composer \
    COMPOSER_MEMORY_LIMIT=-1 \
    APACHE_DOCUMENT_ROOT=/var/www/html/public

WORKDIR /var/www/html

# -----------------------------------------------------------------------------
# Dependências de sistema
# -----------------------------------------------------------------------------
RUN apt-get update && apt-get install -y --no-install-recommends \
        curl \
        git \
        libicu-dev \
        libzip-dev \
        unzip \
        tzdata \
        procps \
    && rm -rf /var/lib/apt/lists/*

# -----------------------------------------------------------------------------
# Extensões PHP
# As mesmas do ambiente FPM original: bcmath, intl, opcache, pcntl,
# pdo_mysql, zip, redis (PECL), pcov e xdebug (dev).
# -----------------------------------------------------------------------------
RUN docker-php-ext-configure intl \
    && docker-php-ext-install -j"$(nproc)" bcmath intl opcache pcntl pdo_mysql zip

RUN pecl install redis \
    && docker-php-ext-enable redis \
    && pecl clear-cache

RUN pecl install pcov xdebug \
    && docker-php-ext-enable pcov xdebug \
    && pecl clear-cache

# -----------------------------------------------------------------------------
# Node.js — via NodeSource (garante exatamente a versão configurada)
# -----------------------------------------------------------------------------
RUN curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION}.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/* \
    && node -v \
    && npm -v

# -----------------------------------------------------------------------------
# Apache — habilita mod_rewrite e mod_headers (necessários para Laravel)
# -----------------------------------------------------------------------------
RUN a2enmod rewrite headers

# -----------------------------------------------------------------------------
# Configurações PHP
# Reutiliza os .ini já existentes no projeto.
# -----------------------------------------------------------------------------
COPY docker/php/conf.d/app.ini         /usr/local/etc/php/conf.d/zz-app.ini
COPY docker/php/conf.d/opcache-dev.ini /usr/local/etc/php/conf.d/zz-opcache.ini
COPY docker/php/conf.d/xdebug.ini      /usr/local/etc/php/conf.d/zzz-xdebug.ini

# -----------------------------------------------------------------------------
# VirtualHost Apache
# -----------------------------------------------------------------------------
COPY docker/monolith/apache.conf /etc/apache2/sites-available/000-default.conf

# -----------------------------------------------------------------------------
# Composer
# -----------------------------------------------------------------------------
COPY --from=composer_bin /usr/bin/composer /usr/local/bin/composer

# -----------------------------------------------------------------------------
# Entrypoint
# -----------------------------------------------------------------------------
COPY docker/monolith/entrypoint.sh /usr/local/bin/entrypoint
RUN sed -i 's/\r$//' /usr/local/bin/entrypoint \
    && chmod +x /usr/local/bin/entrypoint

# -----------------------------------------------------------------------------
# Correções de runtime
# git: evita "detected dubious ownership" no bind mount do host.
# composer cache: cria o diretório antes que alguém seja root ou www-data.
# -----------------------------------------------------------------------------
RUN git config --system --add safe.directory /var/www/html \
    && mkdir -p "$COMPOSER_HOME/cache" \
    && chown -R www-data:www-data "$COMPOSER_HOME"

EXPOSE 80 5175

HEALTHCHECK --interval=15s --timeout=3s --start-period=30s --retries=5 \
    CMD curl --fail --silent --show-error http://127.0.0.1/favicon.ico || exit 1

ENTRYPOINT ["entrypoint"]
CMD ["apache2-foreground"]
