<p align="center">
  <h1 align="center">⚡ Search Wallet Cripto — Web3 Portfolio & Analytics</h1>
  <p align="center">
    Painel completo de monitoramento, auditoria e consolidação patrimonial de carteiras Web3 multi-chain desenvolvido com <b>Laravel 13</b>, <b>Filament v5</b> e <b>Zerion API v1</b>.
  </p>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Status-Em_Desenvolvimento-yellow?style=for-the-badge" alt="Status" />
  <img src="https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.3" />
  <img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
  <img src="https://img.shields.io/badge/Filament-v5-FFA500?style=for-the-badge&logo=livewire&logoColor=white" alt="Filament" />
  <img src="https://img.shields.io/badge/TailwindCSS-v4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
  <img src="https://img.shields.io/badge/API-Zerion_v1-0052FF?style=for-the-badge" alt="Zerion API" />
</p>

---

> 🚧 **Status do Projeto:** Aplicação em desenvolvimento ativo com foco em engenharia de dados on-chain, arquitetura de microsserviços e consumo resiliente de APIs Web3. Abaixo estão detalhadas as funcionalidades **já operacionais** e as **próximas etapas de desenvolvimento**.

---

## Sobre o Projeto

O **Search Wallet Cripto** é uma plataforma analítica para rastreamento, auditoria e consolidação patrimonial de carteiras blockchain. O sistema integra-se diretamente com a **Zerion API v1**, consumindo e persistindo dados indexados em alta velocidade, proporcionando uma experiência de visualização profissional inspirada nas melhores ferramentas do mercado Web3 (como Arkham Intelligence, DeBank e Nansen).

---

## 🎮 Telas do Sistema

<div align="left">
<img src="https://github.com/user-attachments/assets/f9164b2b-d3a7-4828-8a34-7b48793b131d" width="400px" />
<img src="https://github.com/user-attachments/assets/9f11023f-d15f-40e9-88b1-07731465a739" width="400px" />
<img src="https://github.com/user-attachments/assets/1a780c2c-32ee-4c0e-b5a7-072a58ecf638" width="400px" />
<img src="https://github.com/user-attachments/assets/3efc7d00-373e-4da6-b5e4-620bd32c24ea" width="400px" />
</div>

---

## ✨ Funcionalidades Atuais (Implementadas)

### 💰 1. Consolidação de Saldos & Tokens Fungíveis
- [x] **Leitura Multi-chain**: Captura de saldos em dezenas de redes EVM (Ethereum, Polygon, Arbitrum, Optimism, Base, BSC, Avalanche, etc.).
- [x] **Conversão e Cotação em Tempo Real**: Valor total em USD, cotação unitária atual e quantidade de tokens com decimais corretos.
- [x] **Métricas de Dominância**: Cálculo dinâmico do percentual de participação de cada ativo no patrimônio total.
- [x] **Filtro Anti-Spam / Phishing**: Exclusão automática de tokens falsos e airdrops maliciosos (`filter[trash]=only_non_trash`).

### 🌾 2. Posições em Protocolos DeFi
- [x] **Rastreamento de Protocolos**: Mapeamento de posições em Uniswap, Aave, Lido, Curve, MakerDAO, Convex, Yearn, etc.
- [x] **Classificação por Módulos**: Categorização em Staking, Lending, Borrowing, Liquidity Pools e Vaults.
- [x] **Detalhamento de Ativos**: Exibição dos valores depositados, tokens subjacentes e metadados com logos oficiais.

### 🖼️ 3. Galeria & Inventário de NFTs
- [x] **Visualização de Coleções**: Grid interativo de tokens não-fungíveis com previews de imagem em alta definição.
- [x] **Métricas de Valor**: Identificação de *Floor Price* e estimativa de valor da coleção.
- [x] **Paginação Dinâmica**: Navegação fluida com Livewire (12 NFTs por página) e filtro de coleções fraudulentas.

### 📈 4. Gráficos Históricos On-Chain & PnL Nativo (Charts Zerion)
- [x] **Evolução Patrimonial On-Chain**: Gráficos Chart.js de alta precisão consumindo histórico nativo da Zerion API.
- [x] **Múltiplos Períodos**: 1H (1 Hora), 24H (24 Horas), 7D (7 Dias), 1M (1 Mês), 1A (1 Ano) e ALL (Histórico Completo).
- [x] **Cotações Multi-Moeda**: Suporte nativo para visualização em **USD ($)**, **BRL (R$)**, **EUR (€)**, **BTC (₿)** e **ETH (Ξ)**.
- [x] **Filtro por Tipo de Ativo**: Visualizar evolução patrimonial de Todos os Ativos, Apenas Tokens Simples ou Apenas DeFi.
- [x] **KPIs Financeiros de PnL**:
  - PnL nominal e percentual no período.
  - Máxima Histórica (ATH) e Mínima Histórica (ATL) com data e hora exata.
  - Média patrimonial e identificação de tendência (*Bullish / Bearish*).
- [x] **Camada Inteligente de Cache**: Cache Laravel com TTL dinâmico por período e botão para recarga forçada / limpeza de cache sob demanda.

### 📊 5. Dashboard Analítico & Visão Consolidada
- [x] **Visão "Todas as Carteiras"**: Agregação instantânea de saldos e gráficos consolidados via snapshots do banco.
- [x] **Filtro por Rede**: Filtro seletivo de ativos por rede blockchain individual.
- [x] **Health Score da Carteira**: Índice de saúde patrimonial baseado no percentual alocado em stablecoins e blue chips (ETH, WBTC, SOL, BNB).
- [x] **Top Buys & Momentum**: Mapeamento de alocação de ativos com cálculo de preço médio estimado (DCA) e indicador de acumulação.

### 🛡️ 6. Gestão, Segurança & Auditoria
- [x] **Zero Custódia**: Opera exclusivamente com endereços públicos (`0x...` e domínios ENS `.eth`). Nunca armazena chaves privadas ou seed phrases.
- [x] **Resiliência na Integração**: Retries com backoff exponencial para erros 5xx, tratamento de limites de requisição (*Rate Limit - HTTP 429*) com avisos amigáveis.
- [x] **Auditoria Completa de API**: Tabela de logs `zerion_sync_logs` registrando endpoints, tempo de resposta em ms, status e consumo.
- [x] **Sincronização Manual com Feedback**: Ação de sync no painel Filament com notificações toast detalhando tokens, posições DeFi, NFTs e transações gravados.

### 📜 7. Histórico & Auditoria de Transações Decodificadas
- [x] **Ingestão On-Chain Decodificada**: Ingestão de transações em linguagem amigável com classificação em Swaps, Envios, Recebimentos, Depósitos e Resgates.
- [x] **Deltas de Ativos**: Discriminação de fluxos de ativos transferidos (`sent` e `received`) com ícones e valores em USD.
- [x] **Auditoria de Taxas de Gás**: Cálculo e consolidação exata dos custos de rede em USD por transação.
- [x] **Aba Dedicada no Dashboard**: Tabela responsiva com filtros dinâmicos por tipo de operação e paginação Livewire.
- [x] **Links Diretos para Exploradores**: Acesso direto aos block explorers (Etherscan, BscScan, Polygonscan, Arbiscan, Basescan, etc.).

---

## 🚧 Funcionalidades Faltantes & Em Desenvolvimento (Roadmap)

A tabela abaixo detalha o que ainda falta para a versão final da plataforma:

| Funcionalidade | Status | O Que Falta / Objetivo |
| :--- | :---: | :--- |
| **📜 Histórico & Auditoria de Transações** | ✅ Concluído | Ingestão no `WalletSyncService::saveTransactions`, persistência em `wallet_transactions`, aba no Dashboard com deltas, taxas de gas e links para block explorers. |
| **⚙️ Sincronização Automatizada em Background** | ⏳ Pendente | Criar job assíncrono `SyncWalletJob` via Laravel Queues e agendamento no Scheduler (`routes/console.php`) para rodar periodicamente (ex: a cada 6h com rate limiter). |
| **⚡ Suporte a Solana e Redes Não-EVM** | ⏳ Pendente | Expandir validações de formulário e sincronização para aceitar endereços Solana (Base58) e domínios `.sol`. |
| **🔄 Paginação por Cursor na API** | ⏳ Pendente | Implementar iteração sobre o cursor `links.next` na Zerion API para sincronizar carteiras com mais de 100 tokens ou milhares de NFTs. |
| **🔔 Webhooks & Alertas em Tempo Real** | ⏳ Pendente | Criar endpoint receptor de Webhooks para notificações automáticas de movimentações de baleias e transferências na carteira. |
| **📑 Exportação de Extratos (PDF / CSV)** | ⏳ Pendente | Geração de relatórios patrimoniais para declaração fiscal e imposto de renda sobre criptoativos. |
| **🔍 Infolist Customizado de Carteiras** | ⏳ Pendente | Implementar componentes no `WalletInfolist.php` para resumo executivo na tela de detalhes da carteira. |

---

## 🏗️ Arquitetura do Sistema

```text
Usuário (Filament v5 / Livewire / Alpine.js)
    │
    ▼
Módulo de Carteiras (Laravel Models & Policies)
    │
    ▼
Camada de Serviços & Integração
    ├── WalletSyncService (Orquestração de persistência atômica)
    └── ZerionService (HTTP Client, Basic Auth, Retries, Cache & Rate Limiting)
    │
    ▼
Zerion REST API v1
    ├── /v1/wallets/{address}/positions (Tokens & DeFi)
    ├── /v1/wallets/{address}/nft-positions (Inventário NFT & Floor Price)
    ├── /v1/wallets/{address}/charts/{period} (Histórico On-Chain & PnL)
    └── /v1/wallets/{address}/transactions (Auditoria de Movimentações)
    │
    ▼
Banco de Dados Relacional (SQLite / PostgreSQL / MySQL)
    ├── wallets & wallet_snapshots
    ├── wallet_token_balances
    ├── wallet_defi_positions
    ├── wallet_nfts
    ├── wallet_transactions
    └── zerion_sync_logs
```

---

## 🛠️ Tecnologias Utilizadas

* **Linguagem**: PHP 8.3+
* **Framework**: Laravel 13.x
* **Painel Administrativo**: Filament v5 (Livewire 3 / Alpine.js)
* **Gráficos & Frontend**: Chart.js, Tailwind CSS v4, Vite
* **API de Indexação Web3**: Zerion API v1
* **Banco de Dados**: SQLite (desenvolvimento) / MySQL ou PostgreSQL (produção)
* **Testes & Qualidade**: PHPUnit / Pest / Laravel Pint

---

## 🚀 Como Executar o Projeto Localmente

### Pré-requisitos
* PHP 8.3+ com extensões `pdo_sqlite`, `curl`, `mbstring`, `openssl`
* Composer
* Node.js (v20+) & NPM
* Chave de API da Zerion ([Obtenha sua chave gratuita aqui](https://developers.zerion.io/))

### Passo a Passo
   ```bash
   git clone https://github.com/eduardon0bre/search_wallet_cripto.git
   cd search_wallet_cripto
   ```

2. **Configure o arquivo de ambiente:**
   ```bash
   cp .env.example .env
   composer run setup
   php artisan make:filament-user
   php artisan serve
   ```
   *Abra o arquivo `.env` e configure sua chave da Zerion API:*
   ```env
   ZERION_API_KEY=sua_chave_zerion_aqui
   ```

3. **Execute a instalação automatizada:**
   ```bash
   composer run setup
   ```
   *(Este comando instala dependências do Composer e NPM, gera a `APP_KEY`, roda as migrações do banco e compila os assets).*

4. **Crie um usuário para o painel administrativo:**
   ```bash
   php artisan make:filament-user
   ```

5. **Inicie o servidor de desenvolvimento:**
   ```bash
   php artisan serve
   ```

