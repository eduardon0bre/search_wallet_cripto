# Search Wallet Crypto (Em desenvolvimento)

Aplicação desenvolvida em **Laravel 13** + **Filament** para consulta de carteiras Web3 utilizando a API da **Zapper**.
O projeto permite cadastrar carteiras, consultar informações diretamente na API da Zapper e, futuramente, sincronizar tokens, NFTs e posições DeFi.

## Tecnologias

- PHP 8.3+
- Laravel 13
- Filament 5
- SQLite
- GraphQL
- Zapper API

---

## Pré-requisitos

- PHP 8.3 ou superior
- Composer
- Node.js
- NPM
- Git

---

## Configuração

### 1. Clone o repositório

```bash
git clone https://github.com/eduardon0bre/search_wallet_cripto.git
```

```bash
cd search_wallet_cripto
```

### 2. Instale as dependências do PHP

```bash
composer install
```

### 3. Instale as dependências do Front-end

```bash
npm install
```

### 4. Configure o arquivo `.env`

Copie o arquivo de exemplo:

```bash
cp .env.example .env
```

Gere a chave da aplicação:

```bash
php artisan key:generate
```


## Configuração da API Zapper

É necessário possuir uma conta na Zapper e gerar uma chave de API.

Cadastre-se em:

https://build.zapper.xyz/

Depois adicione ao arquivo `.env`:

```env
ZAPPER_API_KEY=sua_chave_aqui
ZAPPER_ENDPOINT=https://public.zapper.xyz/graphql
```

---

## Executando o projeto

Inicie o servidor Laravel:

```bash
php artisan serve
```

Em outro terminal execute o Vite:

```bash
npm run dev
```

---

## Acessando o painel

Após iniciar os serviços, acesse:

```
http://127.0.0.1:8000/admin
```

O painel administrativo foi desenvolvido utilizando **Filament**.
---

## Estrutura do projeto

```
app/
 ├── Filament/
 ├── Models/
 ├── Services/
 │     └── ZapperService.php
 └── ...
```

---

## Funcionalidades

- Cadastro de carteiras
- Consulta de carteiras Web3
- Integração com a API GraphQL da Zapper
- Consulta de:
    - Portfolio
    - Tokens
    - NFTs
    - Protocolos DeFi

---

## Próximas funcionalidades

- Sincronização completa da carteira
- Analise multi carteira
- Cotação atual
- Histórico de sincronizações
- Dashboard

---
