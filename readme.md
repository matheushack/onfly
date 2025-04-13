# Onfly

---

## Índice

- [Pré-requisitos](#pré-requisitos)
- [Instalação](#instalação)
- [Configuração](#configuração)
- [Documentação](#documentação)
- [Testes](#testes)

---

## Pré-requisitos

- **PHP 8.2** ou superior
- **Composer**
- **Banco de Dados:** MySQL.

---

## Instalação

1. **Clone o repositório**

   ```bash
   git clone https://github.com/matheushack/onfly.git
    ```
   Acesse a pasta do projeto
   ```  
   cd onfly
    ```

2. **Criação do docker**

   ```bash
   docker compose up -d --build
   ```

   Acesse o container
   ```bash
   docker exec -it onfly_app bash
   ```   

3. **Instalação das dependências**

   ```bash
   composer install
   ```

## Configuração

1. **Criação do arquivo .env**
   ```bash
   cp .env.example .env
   ```
2. **Gerar chave de criptografia**
   ```bash
   php artisan key:generate
   ```   
3. **Ajustar configurações do banco de dados no .env**
   ```
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=onfly
    DB_USERNAME=onfly
    DB_PASSWORD=secret
   ```      
4. **Rodar as migrations**
   ```bash
   php artisan migrate
   ```
5. **Criar o link simbólico para ter acesso a documentação**
   ```bash
   php artisan storage:link
   ```   
6. **Caso necessário, dar permissões de escrita nas pastas storage e bootstrap**
   ```bash
   chmod 777 -Rf storage bootstrap
   ```      
7. **Para criar um usuário, basta rodar o comando e seguir as instruções**
   ```bash
   php artisan onfly:create-user
   ```

## Documentação

Para ter acesso a documentação, basta acessar o endereço http://localhost

## Testes

Para executar os testes automatizados, utilize o comando:

   ```bash
   php artisan test
   ```