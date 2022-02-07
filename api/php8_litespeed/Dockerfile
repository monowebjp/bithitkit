FROM ubuntu:20.04

ARG LSPHP_VERSION
ARG PHP_VERSION

RUN apt-get update && apt-get install -y --no-install-recommends \
    tzdata \
    curl \
    ca-certificates \
    wget \
    && wget -O - http://rpms.litespeedtech.com/debian/enable_lst_debian_repo.sh | bash

ENV TZ Asia/Tokyo

RUN apt-get update && apt-get install -y --no-install-recommends \
    vim \
    git \
    zip \
    unzip \
    openlitespeed \
    ${LSPHP_VERSION} \
    ${LSPHP_VERSION}-common \
    ${LSPHP_VERSION}-mysql \
    ${LSPHP_VERSION}-curl \
    ${LSPHP_VERSION}-intl \
    && rm -rf /var/lib/apt/lists/*

EXPOSE 7080 8088

COPY ./litespeed/conf/httpd_config.conf /usr/local/lsws/conf/httpd_config.conf
COPY ./litespeed/conf/vhconf.conf /usr/local/lsws/conf/vhosts/www/vhconf.conf

RUN sed -i -r 's/upload_max_filesize = [0-9]+M/upload_max_filesize = 50M/g' /usr/local/lsws/${LSPHP_VERSION}/etc/php/${PHP_VERSION}/litespeed/php.ini
RUN sed -i -r 's/post_max_size = [0-9]+M/post_max_size = 50M/g' /usr/local/lsws/${LSPHP_VERSION}/etc/php/${PHP_VERSION}/litespeed/php.ini

ENV PATH $PATH:/usr/local/lsws/lsphp80/bin/

RUN wget https://getcomposer.org/installer -O composer-installer.php \
    && php composer-installer.php --filename=composer --install-dir=/usr/local/bin \
    && rm -f composer-installer.php

CMD ["sh", "-c", "/usr/local/lsws/bin/lswsctrl start; tail -F /usr/local/lsws/logs/error.log /usr/local/lsws/logs/access.log"]

WORKDIR /var/www/html
