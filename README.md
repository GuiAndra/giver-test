# Como rodar o projeto:

Primeiramente certifique-se que o nginx/apache, mysql e redis não esteja rodando na sua máquina e tenha instalado o docker e docker-compose

## Clone o repositório 
    ```
    git clone https://github.com/GuiAndra/giver-test.git
    ```

## Acesse a pasta do projeto

    ```
    cd giver-test
    ```

## Copie o arquivo .env-example para .env

    ```
    cp .env.example .env
    ```

## Rode o seguinte comando para rodar o composer com a versão correta do php

    ```
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
    ```

## Suba os containers com o laravel sail

    ```
    ./vendor/bin/sail up -d
    ```

## Gerar a key do laravel

    ```
    ./vendor/bin/sail artisan key:gen
    ```

## Rodar migrations

    ```
    ./vendor/bin/sail artisan migrate
    ```

## Build js

    ```
    ./vendor/bin/sail npm install
    ./vendor/bin/sail npm run dev
    ```

# Acesse o projeto em localhost!