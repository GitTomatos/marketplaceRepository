FROM php:8.0-cli
RUN apt-get update \
  && apt-get install -y git \
  #Устнавливаем ssh сервер
  && apt-get install -y openssh-server

RUN useradd --create-home --shell /bin/bash sshuser
RUN echo 'root:root' | chpasswd
RUN echo 'sshuser:123' | chpasswd

WORKDIR /app