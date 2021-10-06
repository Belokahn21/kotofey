FROM php:7.1.33-fpm
#FROM php:7.3.31-fpm

RUN apt-get update \
&& docker-php-ext-install pdo pdo_mysql

RUN apt update
RUN apt install -y sudo

RUN sudo apt install -y vim
RUN sudo apt install -y make