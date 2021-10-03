FROM nginx:latest

RUN apt update
RUN apt install -y sudo

RUN sudo apt install -y vim
RUN sudo apt install -y make

ADD ./docker/nginx/config/kotofey.store.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/kotofey.store