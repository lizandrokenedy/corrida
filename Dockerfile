FROM php:7.4-fpm

# Argumentos passados no docker-compose.yml
ARG user
ARG uid

# Instalando dependências
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Limpando cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalando extenções php
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Obtendo a ultima versão do composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criando usuário para rodar composer e os comandos do artisan
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Diretório de trabalho
WORKDIR /var/www

USER $user
