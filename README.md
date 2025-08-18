## Teste desenvolvedor infornet

O projeto foi desenvolvido usando Laravel no backend e vue js no frontend

Para inicar o container copie o arquivo enviado .env-prd para a raiz do projeto renomeando-o para somente .env e copie tambem o arquivo env.testing

Após execute os seguintes comando no terminal
```
sudo docker compose -f docker-compose-prd.yml up -d
sudo docker exec -it infornet-php-fpm php artisan test --env=testing
sudo docker exec -it infornet-php-fpm php artisan migrate
sudo docker exec -it infornet-php-fpm php artisan db:seed
```

O sistema estará disponível em http://localhost/login

Para chamadas da api http://localhost/api

Para login utilize o email 'user@infornet.com' e a senha '12345678'

## Desenvolvimento
Foi feito com a intenção de oferecer algumas features para desenvolvimento

Para inicar o container de desenvolvimento copie o arquivo enviado .env-dev para a raiz do projeto renomeando-o para somente .env e copie tambem o arquivo env.testing

Após execute os seguintes comando no terminal
```
sudo docker compose -f docker-compose-dev.yml up -d
sudo docker exec -it infornet-php-fpm-dev composer install
sudo docker exec -it infornet-php-fpm-dev php artisan test --env=testing
sudo docker exec -it infornet-php-fpm-dev php artisan migrate
sudo docker exec -it infornet-php-fpm-dev php artisan db:seed
```

