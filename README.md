# Para subir o projeto sempre verificar

## 1. Subir os containers (primeira vez demora mais por causa do build)
docker-compose up -d --build

## 2. Aguarde uns 30 segundos e verifique se está tudo rodando
docker-compose ps

## 3. Acessar o container PHP para instalar o Laravel
docker-compose exec php bash

## 4. Ajustar permissões (ainda dentro do container)
chmod -R 775 storage bootstrap/cache

## 5. Dentro do container, instalar as dependências do Composer
composer install --no-scripts --no-interaction

## 6. Instalação do zero exige a execução das Migrations e Seeders

### Rodar as migrations (criar as tabelas)
docker-compose exec php php artisan migrate

### Rodar os seeders (popular com dados iniciais)
docker-compose exec php php artisan db:seed

### Apaga tudo e recria do zero
docker-compose exec php php artisan migrate:fresh --seed

## Testar a Instalação

### Acesse no navegador: http://localhost:8080
### Para acessar o pgAdmin (gerenciar o banco): http://localhost:5050

Email: andersonrafaelschlender@gmail.com
Senha: admin