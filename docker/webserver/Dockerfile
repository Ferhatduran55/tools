FROM php:8.1-apache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

RUN apt-get update && \
    apt-get install \
    sudo \
    libzip-dev \
    wget \
    git \
    unzip \
    -y --no-install-recommends

RUN docker-php-ext-install zip pdo_mysql

COPY ./php.ini /usr/local/etc/php/

EXPOSE 80

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

WORKDIR /var/www/html

COPY ./package*.json ./

RUN npm install

EXPOSE 3000

RUN apt-get purge -y g++ \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/* \
    && rm -rf /tmp/* 

WORKDIR /var/www/html

ENV APACHE_PORT 80
ENV NODE_PORT 3000
ENV MYSQL_PORT 3306

COPY ./public .

RUN chown -R www-data:www-data /var/www/html

CMD [ "/usr/sbin/apache2ctl", "-D", "FOREGROUND" ]