<p align="center">
  <h1 align="center">⚡ Search Wallet Cripto — Web3 Portfolio & Analytics</h1>
  <p align="center">
    Painel de gestão, monitoramento e consolidação patrimonial de carteiras Web3 multi-chain desenvolvido com <b>Laravel</b> e <b>Filament v5</b>.
  </p>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Status-Em_Desenvolvimento-yellow?style=for-the-badge" alt="Status" />
  <img src="https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.3" />
  <img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
  <img src="https://img.shields.io/badge/Filament-v5-FFA500?style=for-the-badge&logo=livewire&logoColor=white" alt="Filament" />
  <img src="https://img.shields.io/badge/TailwindCSS-v4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
</p>

---

> 🚧 **Status do Projeto:** Este projeto está **em desenvolvimento ativo** para fins de estudo e aprofundamento em arquitetura de integrações Web3, processamento assíncrono e ecossistema moderno do Laravel. Novas features estão sendo incrementadas continuamente.

---

## 📌 Sobre o Projeto

O **Search Wallet Cripto** é uma aplicação para rastreamento patrimonial de carteiras blockchain (EVM). O sistema consome dados on-chain indexados através de uma **API REST especializada em dados Web3**, centralizando informações complexas em um painel administrativo moderno e reativo:

- 💰 **Consolidação Patrimonial**: Totalização em USD de saldos de tokens em múltiplas redes blockchain.
- 🌾 **Posições em Protocolos DeFi**: Rastreamento de posições ativas em Staking, Lending, Borrowing, Liquidity Pools e Vaults.
- 🖼️ **Galeria de NFTs**: Inventário de coleções, metadados e estimativa de *Floor Price*.
- 📜 **Histórico de Transações**: Auditoria detalhada de movimentações com cálculo de taxas de rede (*Gas Fee*) e deltas de entrada/saída de ativos.
- 📊 **Dashboard & Analytics**: Visão analítica com gráficos de distribuição por rede e categorias patrimoniais.

## 🎮 Sobre o Projeto / Telas

<div align="left">
<img src="https://github.com/user-attachments/assets/f9164b2b-d3a7-4828-8a34-7b48793b131d" width="400px" />
<img src="https://github.com/user-attachments/assets/9f11023f-d15f-40e9-88b1-07731465a739" width="400px" />
<img src="https://github.com/user-attachments/assets/1a780c2c-32ee-4c0e-b5a7-072a58ecf638" width="400px" />
<img src="https://github.com/user-attachments/assets/3efc7d00-373e-4da6-b5e4-620bd32c24ea" width="400px" />
</div>

---

## 🏗️ Arquitetura do Sistema

```text
Usuário (Filament Admin Panel)
    │
    ▼
Módulo de Carteiras (Laravel Models & Services)
    │
    ▼
API de Indexação On-Chain (Tratamento de Rate Limit & Retries)
    │
    ├── Consulta de Saldos e Tokens Multi-chain
    ├── Mapeamento de Posições DeFi
    ├── Inventário de Coleções NFT
    └── Histórico de Transações On-chain
    │
    ▼
Banco de Dados Relacional (SQLite / MySQL / PostgreSQL)
```

### 🛡️ Segurança & Boas Práticas
* **Zero Custódia / Read-Only**: O sistema trabalha **exclusivamente com endereços públicos de carteiras**. Chaves privadas (*private keys*) ou palavras-semente (*seed phrases*) **nunca** são solicitadas ou armazenadas.
* **Resiliência na Camada de Integração**: Implementação de políticas de retries automáticos com backoff exponencial, timeouts controlados e tratamento de limite de requisições (*Rate Limiting - HTTP 429*).
* **Processamento em Segundo Plano**: Arquitetura orientada a filas (`Laravel Queues`) para sincronização assíncrona das carteiras, evitando gargalos na navegação do usuário.

---

## 🛠️ Tecnologias Utilizadas

* **Linguagem**: PHP 8.3+
* **Framework**: Laravel 13
* **Painel Administrativo**: Filament v5 (Livewire / Alpine.js)
* **Frontend / Estilização**: Tailwind CSS v4 + Vite
* **Banco de Dados**: SQLite (desenvolvimento) / MySQL ou PostgreSQL (produção)
* **Testes**: PHPUnit / Pest

---

## 🚀 Como Executar o Projeto Localmente

### Pré-requisitos
* PHP 8.3+ com extensões `pdo_sqlite`, `curl`, `mbstring`, `openssl`
* Composer
* Node.js & NPM
* Chave de acesso para a API de dados on-chain

### Passo a Passo

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/seu-usuario/search_wallet_cripto.git
   cd search_wallet_cripto
   ```

2. **Configure as variáveis de ambiente:**
   ```bash
   cp .env.example .env
   ```
   *Edite o arquivo `.env` e insira sua chave de acesso da API Web3:*
   ```env
   ZERION_API_KEY=sua_chave_de_api_aqui
   ```

3. **Execute a instalação automatizada:**
   ```bash
   composer run setup
   ```
   *(Este comando instala os pacotes PHP/Node, gera a chave da aplicação, roda as migrações do banco e compila os assets)*.

4. **Crie um usuário para o painel administrativo:**
   ```bash
   php artisan make:filament-user
   ```

5. **Inicie o servidor e os serviços integrados:**
   ```bash
   composer run dev
   ```

6. **Acesse no navegador:**
   [http://localhost:8000/admin](http://localhost:8000/admin)

---

## 📄 Licença
Este projeto está sob a licença [MIT](LICENSE).
