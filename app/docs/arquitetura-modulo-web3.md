# Módulo Web3 Portfolio - Documentação Inicial

## Objetivo

O módulo Web3 tem como objetivo permitir que usuários da plataforma conectem carteiras blockchain externas e visualizem, em um único lugar:

- Saldo consolidado de tokens
- Valor patrimonial em USD
- Posições em protocolos DeFi
- Inventário de NFTs
- Histórico de transações
- Evolução patrimonial futura

Toda a leitura de dados on-chain será realizada através da API GraphQL da Zapper, abstraindo a necessidade de integração direta com RPCs das blockchains.

---

# Arquitetura

```text
Usuário
    │
    ▼
Carteira Web3
    │
    ▼
Zapper API
    │
    ▼
Serviço de Sincronização
    │
    ├── Tokens
    │
    ├── Posições DeFi
    │
    ├── NFTs
    │
    └── Transações
    │
    ▼
Banco de Dados
    │
    ▼
Dashboard / Filament
```

---

# Escopo da V1

## Funcionalidades

### Carteiras

- Cadastro de múltiplas carteiras
- Apelido personalizado
- Sincronização manual
- Sincronização automática

### Tokens

- Leitura de saldos multi-chain
- Conversão para USD
- Consolidação patrimonial

### DeFi

- Staking
- Lending
- Borrowing
- Liquidity Pools
- Vaults

### NFTs

- Inventário
- Imagens
- Metadados
- Floor Price

### Transações

- Histórico human-readable
- Gas Fee
- Deltas de ativos

---

# Modelo de Dados

## wallets

Representa uma carteira Web3 cadastrada pelo usuário.

| Campo | Tipo | Null |
|---------|---------|---------|
| id | UUID | Não |
| user_id | UUID | Não |
| wallet_address | VARCHAR(42) | Não |
| label | VARCHAR(100) | Sim |
| last_sync_at | TIMESTAMP | Sim |
| created_at | TIMESTAMP | Não |
| updated_at | TIMESTAMP | Não |

### Regras

- Uma carteira pertence a um usuário.
- O mesmo usuário não pode cadastrar a mesma carteira duas vezes.
- Carteiras podem ser compartilhadas entre usuários diferentes.
- Validar formato EVM antes do cadastro.

---

## wallet_token_balances

Representa os ativos encontrados na carteira.

| Campo | Tipo | Null |
|---------|---------|---------|
| id | UUID | Não |
| wallet_id | UUID | Não |
| network | VARCHAR(50) | Não |
| token_address | VARCHAR(42) | Sim |
| symbol | VARCHAR(20) | Não |
| name | VARCHAR(150) | Sim |
| decimals | TINYINT | Sim |
| balance_quantity | DECIMAL(38,18) | Não |
| balance_usd | DECIMAL(24,8) | Não |
| token_price_usd | DECIMAL(24,8) | Sim |
| synced_at | TIMESTAMP | Não |

### Regras

- Token é único por:
  - wallet_id
  - network
  - token_address

- Tokens nativos possuem:

```text
token_address = NULL
```

Exemplos:

```text
ETH
BNB
MATIC
AVAX
```

---

## wallet_defi_positions

Representa posições em protocolos DeFi.

| Campo | Tipo |
|---------|---------|
| id | UUID |
| wallet_id | UUID |
| protocol_name | VARCHAR(100) |
| protocol_slug | VARCHAR(100) |
| protocol_logo_url | VARCHAR(500) |
| network | VARCHAR(50) |
| position_type | VARCHAR(50) |
| total_value_usd | DECIMAL(24,8) |
| assets_data | JSON |
| synced_at | TIMESTAMP |

### Position Types

```text
staking
lending
borrowing
liquidity_pool
yield_farming
vault
```

### Regras

Os ativos internos da posição serão armazenados em JSON.

Exemplo:

```json
{
  "supplied": [],
  "borrowed": [],
  "rewards": []
}
```

---

## wallet_nfts

Representa NFTs encontrados na carteira.

| Campo | Tipo |
|---------|---------|
| id | UUID |
| wallet_id | UUID |
| collection_name | VARCHAR(255) |
| collection_address | VARCHAR(42) |
| token_id | VARCHAR(100) |
| image_url | VARCHAR(1000) |
| floor_price_usd | DECIMAL(24,8) |
| network | VARCHAR(50) |
| metadata | JSON |
| synced_at | TIMESTAMP |

### Regras

NFT único por:

```text
wallet_id
collection_address
token_id
```

O floor price é apenas informativo.

---

## wallet_transactions

Representa o histórico de movimentações.

| Campo | Tipo |
|---------|---------|
| id | UUID |
| wallet_id | UUID |
| tx_hash | VARCHAR(100) |
| network | VARCHAR(50) |
| transaction_at | TIMESTAMP |
| action_type | VARCHAR(50) |
| friendly_description | TEXT |
| gas_fee_usd | DECIMAL(24,8) |
| asset_deltas | JSON |

### Regras

- Transações são imutáveis.
- Apenas inserções.
- Nunca atualizar dados históricos.
- Hash deve ser único por carteira.

Exemplo de asset_deltas:

```json
{
  "received": [
    {
      "symbol": "USDC",
      "amount": 1500
    }
  ],
  "sent": [
    {
      "symbol": "ETH",
      "amount": 0.5
    }
  ]
}
```

---

## zapper_sync_logs

Controle de auditoria e consumo da API.

| Campo | Tipo |
|---------|---------|
| id | UUID |
| wallet_id | UUID |
| endpoint | VARCHAR(100) |
| credits_used | INTEGER |
| response_time_ms | INTEGER |
| status | VARCHAR(20) |
| error_message | TEXT |
| created_at | TIMESTAMP |

### Regras

Toda chamada para a Zapper deve gerar um log.

---

# Fluxo de Sincronização

## Manual

Usuário acessa a carteira:

```text
Minha Conta
    └── Carteiras
            └── Sincronizar
```

---

## Automático

Job Laravel:

```php
SyncWalletJob
```

Execução recomendada:

```text
A cada 6 horas
```

---

## Controle de Rate Limit

Antes de consultar a Zapper:

Verificar:

```text
last_sync_at
```

Se menor que:

```text
5 minutos
```

Cancelar nova sincronização.

---

# Cálculo Patrimonial

Patrimônio total:

```text
SUM(balance_usd)
+
SUM(total_value_usd)
+
SUM(floor_price_usd)
```

Resultado:

```text
total_portfolio_usd
```

---

# Segurança

## Nunca armazenar

- Private Key
- Seed Phrase
- Recovery Phrase
- Wallet Password

O sistema trabalha apenas com:

```text
Wallet Address
```

---

# Estrutura Laravel

```text
app/
├── Models/
│   ├── Wallet.php
│   ├── WalletTokenBalance.php
│   ├── WalletDefiPosition.php
│   ├── WalletNft.php
│   └── WalletTransaction.php
│
├── Services/
│   ├── ZapperService.php
│   ├── WalletSyncService.php
│   ├── TokenSyncService.php
│   ├── DefiSyncService.php
│   ├── NftSyncService.php
│   └── TransactionSyncService.php
│
├── Jobs/
│   └── SyncWalletJob.php
│
└── Filament/
```

---

# Roadmap

## V1

- Cadastro de carteiras
- Sincronização manual
- Tokens
- Dashboard patrimonial

## V2

- DeFi
- NFTs

## V3

- Histórico de transações
- Busca e filtros

## V4

- Evolução patrimonial
- Alertas

## V5

- Relatórios PDF