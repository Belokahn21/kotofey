FROM php:7.3.31-fpm

RUN apt-get update \
&& docker-php-ext-install pdo pdo_mysql

RUN apt install -y sudo
RUN apt update
RUN sudo apt install -y vim make make systemd

RUN apt-get -y install memcached libc6 libevent-2.1-7 libsasl2-2 libssl1.1 libmemcached-tools