# API Corredores

Projeto desenvolvido para gerênciar corredores, provas, resultados e classificações.

## Tecnologias utilizadas

- PHP 7.4 FPM
- Laravel 8
- MySQL 5.7
- Nginx
- Docker
- Docker Compose

## Instruções para subir o ambiente

Para disponibilizar o ambiente é necessário ter a ultima versão do docker e docker-compose instaladas em sua máquina, caso tenha alguma dúvida de como efetuar a instalação, acesse:
[Tutorial Instalação Docker](https://docs.docker.com/engine/install/) escolha sua distribuição.
[Tutorial Instalaçao Docker Compose](https://docs.docker.com/compose/install/) escolha sua distribuição.

Siga as seguintes instruções:

Começaremos cloando o projeto, acesse o diretório onde você costuma rodar seus projetos e execute o comando:

```bash
git clone https://github.com/lizandrokenedy/corrida.git
```

## Configurando as variáveis de ambiente

No diretórios do projeto, execute o comando:

```bash
cp .env.example .env
```

Acesse o arquivo .env e efetue as modificações nos seguintes trechos:

```bash
DB_CONNECTION=mysql
DB_HOST=SEU IP LOCAL #192.168.0.1
DB_PORT=3308
DB_DATABASE=corrida
DB_USERNAME=root
DB_PASSWORD=SUA-SENHA #123456
```

Defina o DB_HOST com seu IP LOCAL
Defina o DB_PASSWORD com uma senha de sua escolha

Obs: Essas variáveis serão utilizadas para criar os acessos a base de dados docker, por default o usuário será sempre o root.

Faremos um build da imagem do php:7.4-fpm para personalizar e instalar algumas depedências definidas no arquivo Dockerfile.

```bash
sudo docker-compose build
```

Agora iremos subir os containers.

```bash
sudo docker-compose up -d
```

Este comando irá subir uma instância do php:7.4-fpm, nginx:alpine e mysql:5.7

Em seguida, faremos a instalação das dependencias

```bash
sudo docker-compose exec app composer install
```

E por fim, rodamos nossas migrations e seeds para criar nossas tabelas e popular os tipos de provas.

```bash
sudo docker-compose exec app php artisan migrate --seed
```

Atenção: **O parâmetro --seed everá ser passado apenas uma vez**, caso contrários ele irá inserir os dados novamente na base gerando um duplicidade.

Acesse a documentação da api, através da url:

```text
http://localhost:8000/swagger/
```
