## API em Laravel

Sistema simples para cadastrar e alterar lojas e produtos. Ao cadastrar ou alterar um produto é enviada uma notificação via email para a loja cadastrada. 

### Instalação

Primeiro deve-se criar o arquivo .env e configurar a conexão com o banco de dados.

Executar os seguintes comandos:

```bash
composer install
php artisan config:cache
php artisan db:seed
php artisan serve
```
Para rodar os testes é necessário ter o xdebug configurado e adicionar a linha ```xdebug.mode=coverage```  no arquivo php.ini

```bash
composer test
```

EndPoints padrão REST

```
GET     api/lojas 
POST    api/lojas 
GET     api/lojas/{loja} 
PUT     api/lojas/{loja} 
DELETE  api/lojas/{loja}  
GET     api/lojas/{loja}/produtos  
POST    api/lojas/{loja}/produtos 
GET     api/lojas/{loja}/produtos/{produto}  
PUT     api/lojas/{loja}/produtos/{produto}  
DELETE  api/lojas/{loja}/produtos/{produto} 
```
