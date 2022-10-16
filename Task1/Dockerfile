FROM php:7.4-cli

COPY . /usr/src/task1
WORKDIR /usr/src/task1

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer

RUN composer install

WORKDIR /usr/src/task1