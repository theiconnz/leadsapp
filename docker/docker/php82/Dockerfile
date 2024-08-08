FROM php:8.2-fpm

ARG PHP_TIMEZONE
ARG PHP_MEMORY_LIMIT
ARG USER_ID
ARG ssh_prv_key
ARG ssh_pub_key

# Configure Node.js version
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash


RUN apt-get update && apt-get install -y \
    openssl \
    git \
    unzip \
    libzip-dev \
    libmagickwand-dev \
    inkscape

# Install dependencies
RUN apt-get update \
  && apt-get upgrade -y \
  && apt-get install -y --no-install-recommends \
  apt-utils \
  cron \
  git \
  mariadb-client \
  nano \
  nodejs \
  python3 \
  python3-pip \
  redis-tools \
  rsyslog \
  sendmail \
  sendmail-bin \
  sudo \
  unzip \
  vim \
  libjpeg62-turbo-dev \
  libpng-dev \
  libfreetype6-dev \
  wget \
  libgmp-dev \
  libmagickwand-dev \
  libmagickcore-dev \
  libc-client-dev \
  libkrb5-dev \
  libicu-dev \
  libldap2-dev \
  libpspell-dev \
  librecode0 \
  librecode-dev \
  libxslt1-dev \
  libyaml-dev \
  libzip-dev \
  zip \
  && rm -rf /var/lib/apt/lists/*

RUN pecl install xdebug mongodb \
    memcache \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-enable memcache \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl


#RUN apt-get install jpegoptim optipng gifsicle webp



COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions bcmath gd mysqli pdo_mysql pdo_pgsql redis uuid zip sockets opcache gettext gmp sysvmsg soap xsl exif ldap sysvsem sysvshm


# Configure the gd library
#RUN docker-php-ext-configure \
#  gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-configure \
  gd --with-freetype --with-jpeg
RUN docker-php-ext-configure \
  imap --with-kerberos --with-imap-ssl
#RUN docker-php-ext-configure \
#  ldap --with-libdir=lib/x86_64-linux-gnu
RUN docker-php-ext-configure \
  opcache --enable-opcache
#RUN docker-php-ext-configure \
#  zip --with-libzip


# Install required PHP extensions

RUN apt-get install -y nodejs npm git git-core

RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*
RUN printf "\n" | pecl install imagick
RUN docker-php-ext-enable imagick

#RUN mkdir -p /tmp/libsodium  \
#  && curl -sL https://github.com/jedisct1/libsodium/archive/1.0.18-RELEASE.tar.gz | tar xzf - -C  /tmp/libsodium \
#  && cd /tmp/libsodium/libsodium-1.0.18-RELEASE/ \
##  && ./configure \
#  && make && make check \
#  && make install  \
#  && cd / \
#  && rm -rf /tmp/libsodium  \
#  && pecl install -o -f libsodium

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${PHP_TIMEZONE} /etc/localtime && echo ${PHP_TIMEZONE} > /etc/timezone

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${PHP_TIMEZONE} /etc/localtime && echo ${PHP_TIMEZONE} > /etc/timezone

COPY crontab /etc/cron.d/cool-task
RUN crontab -u www-data /etc/cron.d/cool-task
RUN chmod 0644 /etc/cron.d/cool-task

RUN crontab /etc/cron.d/cool-task
#CMD cron

#RUN apt-get update -yqq \
# && apt-get install -yqq \
    # install sshd
#    openssh-server \
    # install ping and netcat (for debugging xdebug connectivity)
#    iputils-ping netcat \
    # fix ssh start up bug
    # @see https://github.com/ansible/ansible-container/issues/141
# && mkdir /var/run/sshd \
#;

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git

RUN chown www-data:www-data /etc/cron.d/cool-task
#CMD /usr/sbin/cron -f


# Set timezone
RUN ln -snf /usr/share/zoneinfo/${PHP_TIMEZONE} /etc/localtime && echo ${PHP_TIMEZONE} > /etc/timezone

# Copy xdebug and php config.
#COPY conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY conf.d/php.ini /usr/local/etc/php/conf.d/php.ini
COPY conf.d/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Map user id from host user when it's provided
RUN if [ ! -z ${USER_ID} ]; then usermod -u ${USER_ID} www-data; fi
RUN if [ ! -z ${USER_ID} ]; then groupmod -g ${USER_ID} www-data; fi


RUN sed -i 's#__PHP_TIMEZONE__#'"${PHP_TIMEZONE}"'#g' /usr/local/etc/php/conf.d/php.ini

COPY --from=composer:2.2 /usr/bin/composer /usr/local/bin/composer

RUN npm install -g grunt-cli

RUN npm update

RUN mkdir /var/www/session
RUN mkdir /var/www/workspace
RUN mkdir /var/www/.config
RUN mkdir /var/www/.config/composer
RUN mkdir /var/www/.ssh
RUN mkdir /var/www/.npm
RUN mkdir /var/www/.cache
#RUN mkdir /usr/lib/node_modules/npm

#COPY composer/auth.json /var/www/.config/composer/auth.json


RUN chown www-data:www-data -R /var/www/.ssh
RUN chown www-data:www-data -R /var/www/.npm
RUN chown www-data:www-data -R /usr/lib/node_modules
RUN chown www-data:www-data -R /usr
RUN chown www-data:www-data -R /var/www/.cache


RUN chown www-data:www-data -R /var/www/session
RUN chown www-data:www-data -R /var/www/workspace
RUN chown www-data:www-data -R /var/www/.config
RUN chown www-data:www-data -R /var/www/.config/composer

RUN chown www-data:www-data -R /var/www/session


#RUN cp ssh/id_ed25519_ecostore /var/.ssh/id_ed25519_ecostore
#RUN cp ssh/id_ed25519_ecostore.pub /var/.ssh/id_ed25519_ecostore.pub

# set default user and working directory
USER www-data
WORKDIR /var/www/project