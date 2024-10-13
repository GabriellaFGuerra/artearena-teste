# ArteArena Teste

Este é um projeto Laravel desenvolvido para gerenciar contas e faturas. O projeto inclui funcionalidades para criar, visualizar, editar e excluir contas, além de autenticação de usuários e controle de permissões.

## Requisitos

-   PHP 8.2 ou superior
-   Composer
-   SQLite

## Instalação

1. Clone o repositório:

    ```sh
    git clone https://github.com/GabriellaFGuerra/artearena-teste.git
    cd artearena-teste
    ```

2. Instale as dependências do Composer:

    ```sh
    composer install
    ```

3. Copie o arquivo `.env.example` para `.env` e configure suas variáveis de ambiente:

    ```sh
    cp .env.example .env
    ```

4. Gere a chave da aplicação:

    ```sh
    php artisan key:generate
    ```

5. Execute as migrações do banco de dados:

    ```sh
    php artisan migrate
    ```

6. (Opcional) Popule o banco de dados com dados fictícios:

    ```sh
    php artisan db:seed
    ```

## Uso

### Servidor de Desenvolvimento

Para iniciar o servidor de desenvolvimento, execute:

```sh
php artisan serve
```

A aplicação estará disponível em http://localhost:8000.

## Testes

Para executar os testes, use:

```sh
php artisan test
```

## Estrutura do Projeto

**app/Http/Controllers**: Controladores da aplicação.

**app/Models**: Modelos Eloquent.

**database/migrations**: Arquivos de migração do banco de dados.

**resources/views**: Arquivos Blade para as views.

**routes/web.php**: Definição das rotas web.

**tests/Feature**: Testes de funcionalidade.

### Páginas

1. Login: `/login`

2. Cadastro: `/register`

3. Contas: `/bills`

4. Adicionar Conta: `/bills/create`

5. Editar Conta: `/bills/{$id}/edit`

6. Gerar relatório de contas: `/admin/reports/bills`
