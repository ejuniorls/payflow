# PayFlow: Roadmap

Sistema de vendas com catálogo de produtos, carrinho e checkout, construído com uma camada de pagamentos desacoplada que permite trocar ou combinar gateways. O primeiro gateway integrado será a Getnet.

## Objetivos

- Aprender integração real com gateway de pagamento (Pix e cartão).
- Construir uma arquitetura que aceite novos gateways sem alterar o restante do sistema.
- Lidar com problemas do mundo real: webhooks assíncronos, duplicados ou perdidos, pagamentos expirados, estornos e conciliação.

## Stack

| Camada | Tecnologia |
|---|---|
| Backend | Laravel 13 |
| Autenticação | Laravel Fortify (via starter kit Livewire) |
| Banco de dados | MySQL |
| Frontend | Blade, Tailwind CSS 4, daisyUI 5 |
| Interatividade | Livewire 4 com Volt |
| Tempo real | Laravel Reverb |
| Filas e cache | Redis |
| E-mails locais | Mailpit |
| Ambiente | Laravel Sail (Docker) |
| Testes | Pest |
| Qualidade | Laravel Pint, Larastan |
| CI | GitHub Actions |

> O daisyUI é a biblioteca de componentes do projeto. Ele é um plugin do Tailwind, gratuito e baseado só em classes CSS, o que cobre componentes como tabelas e paginação sem custo. O Flux UI, que veio com o starter kit, será removido: as telas existentes serão migradas para o daisyUI.

## Arquitetura

O código é organizado em quatro áreas com responsabilidades bem separadas:

- **Catálogo**: produtos, categorias, imagens e estoque.
- **Carrinho**: itens, quantidades e totais, para visitantes e usuários logados.
- **Pedidos**: checkout, criação do pedido, reserva e devolução de estoque.
- **Pagamentos**: comunicação com os gateways, webhooks, logs e conciliação.

A regra principal: **Pedidos não conhece nenhum gateway específico**. Toda comunicação passa por uma interface genérica.

### Camada de pagamentos

Os gateways seguem o padrão Manager, o mesmo usado pelo Laravel para mail, cache e filesystem. O arquivo `config/payments.php` define o gateway padrão e os drivers disponíveis.

```php
interface PaymentGateway
{
    public function createPix(PaymentRequest $request): PaymentResult;
    public function authorizeCard(PaymentRequest $request, string $cardToken): PaymentResult;
    public function capture(Payment $payment): PaymentResult;
    public function refund(Payment $payment, ?int $amount = null): PaymentResult;
    public function fetchStatus(Payment $payment): PaymentStatus;
    public function parseWebhook(Request $request): WebhookEvent;
}
```

Drivers previstos:

- `FakeGateway`: simula aprovação, recusa e pendência. Usado no desenvolvimento e nos testes.
- `GetnetGateway`: primeira integração real.
- Outros gateways no futuro (ex.: Mercado Pago, Stripe).

### Decisões de modelagem

- Valores monetários sempre em **centavos, como inteiros**.
- `order_items` guarda uma cópia do nome e do preço do produto no momento da compra.
- **Status do pedido e status do pagamento são separados**. Um pedido pode ter várias tentativas de pagamento.
- Toda requisição e todo webhook trocado com o gateway é salvo com o payload bruto em `payment_logs`.
- Nenhum dado de cartão é armazenado no banco, apenas tokens fornecidos pelo gateway.
- Webhooks são idempotentes: a mesma notificação recebida duas vezes não gera efeito duplicado.
- Usuários usam soft delete. O e-mail de uma conta excluída continua reservado; para voltar, a conta é restaurada pelo suporte.

### Tabelas principais

`users`, `addresses`, `categories`, `products`, `product_images`, `carts`, `cart_items`, `orders`, `order_items`, `payments`, `payment_logs`

### Estados

**Pedido:** `pending` > `paid` > `shipped` > `completed`, com saídas para `cancelled` e `expired`.

**Pagamento:** `pending` > `authorized` > `paid`, com saídas para `failed`, `cancelled`, `expired` e `refunded`.

Transições inválidas devem ser bloqueadas no código.

---

## Fases

### Fase 0: Fundação

- [x] Criar o projeto com o starter kit Livewire (Volt, Pest, Fortify)
- [x] Corrigir o `APP_URL` e usar `APP_PORT`
- [x] Ajustar `APP_NAME` e locale para `pt_BR`
- [x] Configurar o Sail com MySQL, Redis e Mailpit
- [x] Subir os containers e rodar as migrations no MySQL
- [x] Finalizar o Pest (`sail pest --init`) e rodar os testes
- [x] Configurar o Larastan (`phpstan.neon`) e validar o Pint
- [x] Criar pipeline no GitHub Actions rodando testes e análise estática
- [x] Escrever o README inicial

**Entregável:** projeto rodando com login e pipeline verde.

### Fase 1: Catálogo

- [x] Papéis de usuário (roles) e acesso ao painel admin protegido por Gate
- [x] Soft delete em `users`, com o e-mail de contas excluídas reservado
- [x] Traduções pt_BR (auth, validação, senhas e paginação)
- [ ] Substituir o Flux UI pelo daisyUI em todas as telas (layouts, auth e settings) e remover o pacote `livewire/flux`
    - [x] Componentes de formulário: `x-button`, `x-input`, `x-link`, `x-checkbox`
    - [x] Ícones com Font Awesome
    - [x] Tipografia: `x-heading`, `x-text`
    - [ ] Layouts de auth (toast)
    - [ ] Telas de configurações e modais
    - [ ] Autenticação em dois fatores (OTP)
    - [x] Layout principal (sidebar e menu do usuário)
    - [ ] Remover o Flux
- [ ] Migrations e models de categorias, produtos e imagens
- [ ] Painel admin com CRUD de categorias
- [ ] Painel admin com CRUD de produtos (preço, estoque, imagens, ativo/inativo)
- [ ] Vitrine pública com listagem paginada
- [ ] Filtro por categoria e busca por nome
- [ ] Página de detalhes do produto
- [ ] Seeders com produtos de demonstração
- [ ] Testes do catálogo

**Entregável:** é possível navegar pelos produtos.

### Fase 2: Carrinho

- [ ] Carrinho vinculado à sessão para visitantes
- [ ] Carrinho vinculado ao usuário logado
- [ ] Mesclar carrinho do visitante ao fazer login
- [ ] Adicionar, remover e alterar quantidade (Livewire)
- [ ] Validar estoque disponível
- [ ] Calcular subtotal e total
- [ ] Testes do carrinho

**Entregável:** carrinho completo e testado.

### Fase 3: Checkout e pedidos com gateway falso

- [ ] Cadastro e seleção de endereço
- [ ] Tela de revisão do pedido
- [ ] Criação do pedido com cópia dos itens
- [ ] Reserva de estoque ao criar o pedido
- [ ] Criar a interface `PaymentGateway`, os DTOs e o Manager
- [ ] Criar `config/payments.php`
- [ ] Implementar o `FakeGateway`
- [ ] Fluxo de compra completo usando o `FakeGateway`
- [ ] Testes do checkout cobrindo aprovação, recusa e pendência

**Entregável:** compra de ponta a ponta com pagamento simulado.

### Fase 4: Getnet com Pix

- [ ] Configurar credenciais da Getnet via `.env`
- [ ] Cliente HTTP próprio usando o `Http` do Laravel
- [ ] Autenticação com access token em cache até expirar
- [ ] Criação da cobrança Pix
- [ ] Tela com QR Code, código copia e cola e contador de expiração
- [ ] Endpoint de webhook em `/webhooks/{gateway}`
- [ ] Processamento do webhook em fila, com idempotência
- [ ] Registro de todas as chamadas em `payment_logs`
- [ ] Atualização da tela em tempo real com Reverb quando o pagamento for confirmado
- [ ] Testes com `Http::fake()`

**Entregável:** primeiro pagamento real no ambiente de homologação.

### Fase 5: Getnet com cartão

- [ ] Tokenização do cartão
- [ ] Autorização com captura imediata
- [ ] Pré-autorização com captura posterior
- [ ] Cancelamento
- [ ] Estorno total e parcial
- [ ] Tratamento de recusas com mensagens amigáveis
- [ ] Testes cobrindo sucesso, recusa e erro de comunicação

**Entregável:** checkout com Pix e cartão.

### Fase 6: Painel de pedidos

- [ ] Área do cliente com histórico e status dos pedidos
- [ ] Lista de pedidos no admin com filtros por status, data e método de pagamento
- [ ] Detalhes do pedido com tentativas de pagamento e logs do gateway
- [ ] Ação de estorno pelo admin
- [ ] Ação de cancelamento pelo admin

**Entregável:** o sistema pode ser operado por alguém.

### Fase 7: Robustez

- [ ] Job agendado que expira pedidos não pagos e devolve o estoque
- [ ] Job de conciliação que consulta o gateway e corrige pagamentos sem webhook
- [ ] Retry com backoff nas chamadas ao gateway
- [ ] E-mails de confirmação de pedido e de pagamento
- [ ] Testes de webhook duplicado, webhook fora de ordem e timeout

**Entregável:** sistema preparado para os problemas do mundo real.

### Fase 8: Segundo gateway

- [ ] Implementar um novo driver (ex.: Mercado Pago)
- [ ] Permitir escolher o gateway por configuração
- [ ] Permitir gateways diferentes por método de pagamento (ex.: Pix em um, cartão em outro)
- [ ] Testes garantindo que o fluxo de pedidos não muda entre gateways

**Entregável:** prova de que a arquitetura suporta múltiplos gateways.

---

## Ideias futuras

- Cupons de desconto
- Cálculo de frete
- Assinaturas com cobrança recorrente usando cartão salvo
- Deploy público com dados de demonstração
- Documentação da arquitetura com diagramas