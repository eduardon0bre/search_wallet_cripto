# Search Wallet Crypto (Em desenvolvimento)

Aplicação desenvolvida em **Laravel 13** + **Filament** para consulta de carteiras Web3 utilizando a API da **Zapper**.
O projeto permite cadastrar carteiras, consultar informações diretamente na API da Zapper e, futuramente, sincronizar tokens, NFTs e posições DeFi.

## 🎮 Sobre o Projeto

<div align="left">
<img src="https://github.com/user-attachments/assets/f9164b2b-d3a7-4828-8a34-7b48793b131d" width="400px" />
 <img src="https://github.com/user-attachments/assets/9f11023f-d15f-40e9-88b1-07731465a739" width="400px" />
  <img src="https://github.com/user-attachments/assets/1a780c2c-32ee-4c0e-b5a7-072a58ecf638" width="400px" />
 <img src="https://github.com/user-attachments/assets/3efc7d00-373e-4da6-b5e4-620bd32c24ea" width="400px" />
</div>

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
