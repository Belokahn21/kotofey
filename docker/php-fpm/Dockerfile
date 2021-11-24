FROM php:7.1.33-fpm

RUN apt-get update \
&& docker-php-ext-install pdo pdo_mysql

RUN apt install -y sudo
RUN apt update
RUN sudo apt install -y vim make make systemd wget