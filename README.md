# PayFlow

Sistema de vendas com catálogo de produtos, carrinho e checkout, construído sobre uma camada de pagamentos desacoplada que permite trocar ou combinar gateways. O primeiro gateway integrado será a Getnet (Pix e cartão).

> Projeto em desenvolvimento. O planejamento completo, com arquitetura, modelagem e fases, está em [roadmap.md](roadmap.md).

## Stack

- Laravel 13 (PHP 8.5) com Fortify para autenticação
- Livewire 4, Volt, Flux UI e Tailwind CSS 4
- MySQL 8.4 e Redis
- Laravel Sail (Docker)
- Pest, Larastan e Laravel Pint

## Requisitos

- Docker com Docker Compose
- No Windows, use o WSL2 e mantenha o projeto dentro do sistema de arquivos do Linux

Não é preciso ter PHP, Composer ou Node instalados na máquina. Tudo roda dentro dos containers.

## Instalação

```bash
git clone <url-do-repositorio> payflow
cd payflow
cp .env.example .env
```

Instale as dependências PHP usando um container temporário:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php85-composer:latest \
    composer install --ignore-platform-reqs
```

Suba os containers e prepare a aplicação:

```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

A aplicação fica disponível em http://localhost:8100.

Para não digitar `./vendor/bin/sail` toda vez, crie um alias no seu `~/.bashrc` ou `~/.zshrc`:

```bash
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```

### Sobre as credenciais do banco

O MySQL cria o usuário e o banco a partir do `.env` apenas na primeira vez que o volume é criado. Se você alterar `DB_DATABASE`, `DB_USERNAME` ou `DB_PASSWORD` depois disso, a aplicação passa a receber `Access denied`. Para recriar o banco com os novos valores (isso apaga os dados locais):

```bash
sail down -v
sail up -d
sail artisan migrate
```

O banco `testing`, usado pelos testes, é criado automaticamente junto.

## Portas

| Serviço | Endereço na sua máquina | Variável no `.env` |
|---|---|---|
| Aplicação | http://localhost:8100 | `APP_PORT` |
| Vite | http://localhost:5173 | `VITE_PORT` |
| MySQL | `127.0.0.1:3310` | `FORWARD_DB_PORT` |
| Redis | `127.0.0.1:6379` | `FORWARD_REDIS_PORT` |

Dentro dos containers, a aplicação acessa o MySQL em `mysql:3306` e o Redis em `redis:6379`.

## Comandos do dia a dia

| Comando | O que faz |
|---|---|
| `sail up -d` / `sail down` | Sobe ou para os containers |
| `sail npm run dev` | Compila os assets com recarga automática |
| `sail artisan migrate` | Roda as migrations |
| `sail pest` | Roda os testes |
| `sail bin pint` | Formata o código |
| `sail bin phpstan analyse` | Roda a análise estática |
| `sail composer test` | Roda Pint (só conferência), PHPStan e testes em sequência |

Antes de abrir um pull request, rode `sail composer test`. É o mesmo conjunto de verificações que o CI executa.

## Estrutura do domínio

O código é dividido em quatro áreas: **Catálogo**, **Carrinho**, **Pedidos** e **Pagamentos**. Pedidos não conhece nenhum gateway específico. Toda comunicação com gateways passa pela interface `PaymentGateway`, e o driver é escolhido em `config/payments.php`. Os detalhes estão no [roadmap.md](roadmap.md#arquitetura).
