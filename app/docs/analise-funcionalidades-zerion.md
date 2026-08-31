# Análise Comparativa e Diagnóstico de Funcionalidades: Zerion API vs. Search Wallet Cripto

Este documento detalha o comparativo técnico entre os recursos disponibilizados pela **Zerion API (v1)** e o estado atual de implementação no **Search Wallet Cripto**, identificando detalhadamente as **funcionalidades atuais (implementadas)** e as **funcionalidades pendentes / gaps (o que ainda falta)**.

---

## 📊 Matriz Resumo de Funcionalidades

| Funcionalidade Zerion API | Status no Projeto | Local / Implementação | Prioridade |
| :--- | :---: | :--- | :---: |
| **Saldos de Tokens Multi-chain** | ✅ Implementado | `ZerionService::getTokens`, `WalletSyncService::saveTokenBalances`, Dashboard | Alta |
| **Posições DeFi (Staking, Lending, Pools)** | ✅ Implementado | `ZerionService::getAppBalances`, `WalletSyncService::saveDefiPositions`, Dashboard | Alta |
| **Inventário e Metadados NFT** | ✅ Implementado | `ZerionService::getNfts`, `WalletSyncService::saveNfts`, Dashboard (12/pág) | Alta |
| **Filtro Anti-Spam / Trash (`only_non_trash`)** | ✅ Implementado | Aplicado em Tokens, NFTs e Gráficos históricos | Alta |
| **Gráficos Históricos On-Chain (API)** | ✅ Implementado | `ZerionService::getWalletChart`, `WalletAnalytics.php` (Chart.js + Cache) | Alta |
| **Suporte a Múltiplas Moedas (USD, BRL, EUR, BTC, ETH)** | ✅ Implementado | Gráfico Histórico Zerion & Seletor de Cotação no Dashboard | Média |
| **Snapshots Patrimoniais e Consolidação Local** | ✅ Implementado | `WalletSnapshot`, consolidação automática em "Todas as Carteiras" | Média |
| **Logs de Auditoria e Consumo de API** | ✅ Implementado | Tabela `zerion_sync_logs` com status, tempo de resposta e erros | Média |
| **Tratamento de Rate Limit & Resiliência** | ✅ Implementado | Retries com backoff, captura de HTTP 429 e mensagens amigáveis | Média |
| **Histórico Decodificado de Transações** | 🚧 Em Andamento / Pendente | Método existe em `ZerionService`, falta pipeline no sync e aba no Dashboard | Alta |
| **Sincronização em Background (Queues & Cron)** | ⏳ Pendente | Falta criar `SyncWalletJob` e agendamento no Laravel Scheduler | Alta |
| **Suporte a Carteiras Solana e Não-EVM** | ⏳ Pendente | Validações atuais restritas a EVM (`0x...`) e ENS (`.eth`) | Média |
| **Paginação por Cursor (Cursor Pagination)** | ⏳ Pendente | Chamadas limitadas a 100 itens por request (sem iterar `links.next`) | Média |
| **Webhooks de Alertas On-Chain em Tempo Real** | ⏳ Pendente | Falta rota receptora de webhook e notificações de movimentação | Baixa |
| **Exportação de Relatórios e Extratos (PDF/CSV)** | ⏳ Pendente | Relatórios fiscais/contábeis para declaração patrimonial | Baixa |
| **Custom Infolist no Filament Resource** | ⏳ Pendente | `WalletInfolist.php` ainda não possui widgets/componentes de visualização | Baixa |

---

## ✅ 1. Funcionalidades Atuais (Implementadas)

### 1.1 Consolidação Patrimonial e Leitura de Tokens Fungíveis
- **Zerion Endpoint:** `GET /v1/wallets/{address}/positions/?filter[positions]=only_simple`
- **Implementação:**
  - `ZerionService::getTokens()` consulta a API com ordenação por valor patrimonial (`sort=value`) e filtro de tokens legítimos (`filter[trash]=only_non_trash`).
  - `WalletSyncService::saveTokenBalances()` persiste e atualiza atomicamente os registros na tabela `wallet_token_balances`.
  - Armazena símbolo, nome do token, decimais, saldo fracionário (`balance_quantity`), valor total convertido em USD (`balance_usd`), cotação unitária (`token_price_usd`), logo do token (`logo_url`) e identificador da rede (`network`).
  - Apresentado no Dashboard Web3 com barra de dominância percentual sobre o patrimônio total da carteira.

### 1.2 Posições em Protocolos DeFi (Complex Positions)
- **Zerion Endpoint:** `GET /v1/wallets/{address}/positions/?filter[positions]=only_complex`
- **Implementação:**
  - `ZerionService::getAppBalances()` captura posições em protocolos como Uniswap, Aave, Lido, Curve, MakerDAO, Convex, etc.
  - `WalletSyncService::saveDefiPositions()` salva na tabela `wallet_defi_positions` com nome do protocolo, slug, logo oficial, tipo de posição (`staking`, `lending`, `liquidity_pool`, `vault`), valor total em USD e payload JSON completo dos ativos (`assets_data`).
  - Apresentado na aba **DeFi** do Dashboard Web3 com cards organizados por protocolo e rede.

### 1.3 Inventário e Galeria de NFTs
- **Zerion Endpoint:** `GET /v1/wallets/{address}/nft-positions/`
- **Implementação:**
  - `ZerionService::getNfts()` filtra automaticamente coleções fraudulentas (*airdrop scams*) com `filter[trash]=only_non_trash` e ordena por floor price.
  - `WalletSyncService::saveNfts()` persiste na tabela `wallet_nfts` incluindo nome da coleção, contrato, `token_id`, URL da imagem prévia/detalhe, `floor_price_usd`, `estimated_value_usd` e metadados.
  - Apresentado no Dashboard Web3 com grid responsivo, badges de rede e paginação integrada Livewire (12 NFTs por página).

### 1.4 Gráficos Históricos On-Chain e PnL Nativo (Charts & PnL)
- **Zerion Endpoint:** `GET /v1/wallets/{address}/charts/{chart_type}`
- **Implementação:**
  - Integrado diretamente na tela de **Dashboard & Analytics Web3** (`WalletAnalytics.php` + `wallet-analytics.blade.php`).
  - **Múltiplos períodos:** 1H (`hour`), 24H (`day`), 7D (`week`), 1M (`month`), 1A (`year`), ALL (`max`).
  - **Cotações multi-moeda:** USD (`$`), BRL (`R$`), EUR (`€`), BTC (`₿`), ETH (`Ξ`).
  - **Filtro por tipo de posição:** Todas as posições (`no_filter`), Apenas Tokens (`only_simple`), Apenas DeFi (`only_complex`).
  - **Camada inteligente de Cache Laravel:** Cache com TTL proporcional ao período (10 min para 1H até 12h para ALL) e botão para forçar limpeza e sincronização imediata.
  - **KPIs Analíticos:** Valor Inicial, Valor Atual, PnL nominal e percentual no período selecionado, Mínima Histórica (ATL com data), Máxima Histórica (ATH com data), Valor Médio e Indicador de Tendência (Bullish/Bearish).
  - **Modo Consolidado:** Quando "Todas as Carteiras" é selecionada, o gráfico agrega os dados históricos a partir dos snapshots locais salvos no banco.

### 1.5 Filtro Anti-Spam e Proteção contra Phishing (Trash Filter)
- **Implementação:**
  - A flag `filter[trash]=only_non_trash` é aplicada em todas as consultas da Zerion (Tokens, NFTs e Gráficos), impedindo que tokens de airdrop scam ou NFTs maliciosos poluam o patrimônio real do usuário.

### 1.6 Resiliência, Rate Limit e Auditoria de Integração
- **Implementação:**
  - `ZerionService` autentica via HTTP Basic Auth com chave configurável em `.env`.
  - Tratamento de falhas e `retry` automático em erros transitórios de servidor (5xx).
  - Captura inteligente de limites de requisição (**HTTP 429 / Throttled**), retornando mensagens explicativas ao usuário.
  - Gravação automática de logs de auditoria na tabela `zerion_sync_logs` contendo endpoint consultado, tempo de resposta em milissegundos, status (`success`/`error`), créditos consumidos e mensagem de erro (se houver).

### 1.7 Gestão de Carteiras no Painel Administrativo (CRUD)
- **Implementação:**
  - Cadastro de carteiras com validação de formato EVM (`0x...`) e domínios ENS (`.eth`).
  - Tabela Filament com busca, ordenação, filtro de carteiras ativas e botão de cópia de endereço.
  - Ação de sincronização manual (`Sync`) diretamente na listagem de carteiras com Toast Notification detalhando tokens, DeFi e NFTs sincronizados.

---

## 🚧 2. Funcionalidades Pendentes / Faltantes (O Que Ainda Falta)

### 2.1 Histórico Completo e Auditoria de Transações Decodificadas
- **O que a Zerion oferece:** Endpoint `/v1/wallets/{address}/transactions/` com transações decodificadas em linguagem amigável (*human-readable*), discriminando tipo de ação (`buy`, `sell`, `swap`, `deposit`, `withdraw`, `mint`, `burn`), taxas de gás em USD (`gas_fee_usd`) e deltas exatos de ativos transferidos (`asset_deltas`).
- **O que falta no projeto:**
  1. Integrar o método `ZerionService::getTransactions()` dentro do fluxo de `WalletSyncService::syncWallet()`.
  2. Implementar a rotina `saveTransactions()` para persistir na tabela existente `wallet_transactions` (evitando duplicatas por `tx_hash` e `wallet_id`).
  3. Criar uma nova aba dedicada **"Transações"** no Dashboard Web3 (`WalletAnalytics`) exibindo lista cronológica com filtros por tipo, rede e links diretos para exploradores de blocos (Etherscan, Polygonscan, Arbiscan, etc.).
  4. Substituir a aproximação atual de taxas de gás e *Buy Momentum* pelos dados reais das transações persistidas.

### 2.2 Sincronização Assíncrona Automatizada (Jobs, Queues & Scheduler)
- **O que falta no projeto:**
  1. **Job Assíncrono (`SyncWalletJob`):** Executar a sincronização em segundo plano via filas (`Laravel Queues`), impedindo que requisições longas travem a experiência do usuário no painel.
  2. **Comando Artisan (`wallets:sync`):** Criar comando no console para sincronizar carteiras ativas via terminal ou agendador.
  3. **Rotina no Scheduler (`routes/console.php`):** Agendar a sincronização automática periódica (ex: a cada 6 ou 12 horas) com trava de segurança (`needsSync(5)` para evitar rate limit de chamadas repetidas em menos de 5 minutos).

### 2.3 Suporte a Carteiras Solana e Redes Não-EVM
- **O que a Zerion oferece:** Suporte nativo para endereços da rede Solana (formato Base58) além do ecossistema EVM.
- **O que falta no projeto:**
  1. Atualizar as validações em `WalletForm.php` e `WalletSyncService.php` para aceitar também endereços Solana (Base58 de 32 a 44 caracteres) e domínios `.sol`.
  2. Ajustar os mapeamentos de rede para suportar identificadores Solana nos saldos de tokens e NFTs.

### 2.4 Paginação Completa por Cursor (Cursor-based Pagination)
- **O que a Zerion oferece:** Suporte a paginação via cursor (`links.next`) para carteiras com grande volume de dados (ex: *whales* com mais de 100 tokens ou centenas de NFTs).
- **O que falta no projeto:**
  1. O `ZerionService` atualmente realiza requisição única limitando a 100 itens (`page[size]=100`).
  2. Implementar iteração automática sobre `links.next` para coletar o portfólio completo em carteiras com alta densidade de ativos antes de salvar no banco de dados.

### 2.5 Webhooks de Movimentação On-Chain em Tempo Real
- **O que a Zerion oferece:** Recurso `/v1/webhooks` para registrar endpoints HTTP e receber notificações instantâneas de novas transferências/interações nas carteiras monitoradas.
- **O que falta no projeto:**
  1. Criar rota de webhook na API do Laravel (`POST /api/webhooks/zerion`) com validação de assinatura/secret.
  2. Atualizar o portfólio e transações da carteira automaticamente ao receber payload de webhook.
  3. Disparar notificações internas no Filament, e-mail ou Telegram sobre grandes movimentações de baleias.

### 2.6 Exportação de Relatórios e Extratos Fiscais (PDF / CSV)
- **O que falta no projeto:**
  1. Ação para download de extrato consolidado de patrimônio em formato PDF ou planilha CSV.
  2. Relatório de fechamento de posição para fins de declaração fiscal e imposto de renda sobre criptoativos.

### 2.7 Infolist Customizado no Filament Resource
- **O que falta no projeto:**
  1. O arquivo `WalletInfolist.php` encontra-se apenas com a estrutura básica.
  2. Implementar visualização com resumo financeiro, badge de status, lista rápida de top tokens e link direto para o Analytics ao abrir a tela de detalhes de uma carteira específica.

---

## 🎯 Próximas Etapas Recomendadas (Ordem de Prioridade)

1. **Fase I (Imediata):** Implementar a persistência de transações (`wallet_transactions`) no `WalletSyncService` e criar a aba de Transações no Dashboard Web3.
2. **Fase II (Automação):** Criar o `SyncWalletJob` e configurar o Laravel Scheduler para atualizações periódicas automáticas em fila.
3. **Fase III (Expansão Multi-Chain):** Adicionar suporte a carteiras Solana e domínios `.sol` na validação de cadastro.
4. **Fase IV (Escalabilidade):** Implementar paginação de cursor (`links.next`) no `ZerionService` para suportar carteiras com milhares de ativos.
5. **Fase V (Alertas & Relatórios):** Integrar Webhooks da Zerion e exportação de relatórios em PDF/CSV.
