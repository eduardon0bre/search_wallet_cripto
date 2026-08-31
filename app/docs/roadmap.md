# Roadmap de Desenvolvimento — Search Wallet Cripto

## FASE 1 - CRUD & Gestão de Carteiras
- [x] Migration de carteiras (`wallets`)
- [x] Model com UUID e relacionamentos (`Wallet.php`)
- [x] Filament Resource (`WalletResource.php`)
- [x] Formulário de criação com validação EVM/ENS (`WalletForm.php`)
- [x] Tabela Filament com busca, cópia de endereço e ordenação (`WalletsTable.php`)
- [ ] Infolist customizado com resumo financeiro da carteira (`WalletInfolist.php`)

---

## FASE 2 - Integração com Zerion API & Sincronização
- [x] Serviço HTTP cliente para Zerion API (`ZerionService.php`)
- [x] Autenticação Basic Auth e tratamento de Rate Limit (HTTP 429)
- [x] Botão e ação manual de Sincronização na tabela Filament (`Sync`)
- [x] Atualização de timestamp `last_sync_at`
- [x] Tabela de logs e auditoria de chamadas (`zerion_sync_logs`)

---

## FASE 3 - Ingestão & Dados Blockchain
- [x] Sincronização e persistência de saldos de Tokens (`wallet_token_balances`)
- [x] Filtro anti-spam / trash (`filter[trash]=only_non_trash`)
- [x] Sincronização e persistência de Posições DeFi (`wallet_defi_positions`)
- [x] Sincronização e galeria de NFTs com paginação Livewire (`wallet_nfts`)
- [x] Snapshots patrimoniais e consolidação histórica (`wallet_snapshots`)
- [ ] Ingestão do Histórico de Transações decodificadas (`wallet_transactions`)

---

## FASE 4 - Dashboard & Analytics On-Chain
- [x] Página dedicada no Filament (`WalletAnalytics.php` + `wallet-analytics.blade.php`)
- [x] Gráficos históricos Chart.js consumindo Zerion API nativa
- [x] Múltiplos períodos (1H, 24H, 7D, 1M, 1A, ALL)
- [x] Seletor de moedas (USD, BRL, EUR, BTC, ETH) e filtros por tipo de posição
- [x] KPIs de ATH, ATL, PnL, Médias e Tendência
- [x] Cache Laravel inteligente com botão de recarga forçada
- [x] Aba de Tokens com dominância patrimonial
- [x] Aba de Posições DeFi por protocolo
- [x] Aba de NFTs com metadados e floor price
- [x] Aba de Top Buys & Momentum (cálculo de DCA e acumulação)
- [ ] Aba dedicada para Histórico de Transações e Movimentações

---

## FASE 5 - Automação & Escalabilidade
- [ ] Job assíncrono para sincronização em segundo plano (`SyncWalletJob`)
- [ ] Execução via filas assíncronas (`Laravel Queues`)
- [ ] Agendamento periódico no Laravel Scheduler (Cron a cada 6h com rate limiter)
- [ ] Suporte a carteiras da rede Solana (Base58 e `.sol`)
- [ ] Paginação via cursor (`links.next`) para carteiras com grande volume
- [ ] Receptor de Webhooks para alertas on-chain em tempo real
- [ ] Exportação de relatórios fiscais e patrimoniais em PDF / CSV