FROM php:7-fpm

# Installing git to install dependencies later and necessary libraries for postgres
# and mysql including client tools. You can remove those if you don't need them for your build.
RUN apt-get update && \
    apt-get install -y \
      git \
      libpq-dev \
      postgresql-client \
      mysql-client \
      zip \
      unzip \
      make

# Install xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# Install extensions through pecl and enable them through ini files
RUN pecl install hrtime
RUN echo "extension=hrtime.so" > $PHP_INI_DIR/conf.d/hrtime.ini

RUN apt-get -y install libmemcached11 libmemcachedutil2 libmemcached-dev \
        && cd /usr/local/share \
        && git clone --branch php7 https://github.com/php-memcached-dev/php-memcached \
        && cd php-memcached \
        && phpize \
        && ./configure \
        && make \
        && echo "extension=/usr/local/share/php-memcached/modules/memcached.so" > /usr/local/etc/php/conf.d/memcached.ini

# Install Composer and make it available in the PATH
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Install extensions through the scripts the container provides
# Here we install the pdo_pgsql and pdo_mysql extensions to access PostgreSQL and MySQL.
#RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install pdo_mysql

# Set the WORKDIR to /app so all following commands run in /app
WORKDIR /app

# Copy composer files into the app directory.
#COPY code/composer.json code/composer.lock ./

# Install dependencies with Composer.
# --prefer-source fixes issues with download limits on Github.
# --no-interaction makes sure composer can run fully automated
#CMD composer install --prefer-source --no-interaction --no-progress

EXPOSE 9000
CMD ["php-fpm"]
