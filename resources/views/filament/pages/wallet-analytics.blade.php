<x-filament-panels::page>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    @endpush

    @push('styles')
        <style>
            /* Base / Light Mode (Tema Branco -> Fundo Cinza, Cards Escuros) */
            .wa-dashboard {
                background-color: #CBD5E1 !important;
                color: #0F172A !important;
                font-family: 'Inter', system-ui, -apple-system, sans-serif;
                border-radius: 12px;
                padding: 24px;
                margin-top: -10px;
                border: 1px solid #94A3B8;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            }

            .wa-header {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                padding-bottom: 20px;
                border-bottom: 1px solid #94A3B8;
                margin-bottom: 24px;
            }

            .wa-title-group h2 {
                font-size: 1.5rem;
                font-weight: 800;
                color: #0F172A;
                margin: 0;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .wa-title-sub {
                font-size: 0.8rem;
                color: #475569;
                margin-top: 4px;
            }

            .wa-text-main {
                color: #F8FAFC;
            }

            .wa-text-sub {
                color: #94A3B8;
            }

            .wa-text-accent {
                color: #38BDF8;
            }

            .wa-pulse-dot {
                width: 10px;
                height: 10px;
                background-color: #0ECB81;
                border-radius: 50%;
                display: inline-block;
                box-shadow: 0 0 10px #0ECB81;
            }

            .wa-badge {
                display: inline-flex;
                align-items: center;
                padding: 3px 8px;
                border-radius: 4px;
                font-weight: 700;
                font-size: 0.7rem;
                letter-spacing: 0.5px;
                text-transform: uppercase;
            }

            .wa-badge-success {
                background-color: rgba(14, 203, 129, 0.2);
                color: #0ECB81;
                border: 1px solid rgba(14, 203, 129, 0.4);
            }

            .wa-badge-danger {
                background-color: rgba(246, 70, 93, 0.2);
                color: #F6465D;
                border: 1px solid rgba(246, 70, 93, 0.4);
            }

            .wa-filters {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 12px;
            }

            .wa-filter-box {
                display: flex;
                flex-direction: column;
            }

            .wa-filter-label {
                font-size: 0.65rem;
                font-weight: 700;
                color: #475569;
                text-transform: uppercase;
                margin-bottom: 4px;
                letter-spacing: 0.5px;
            }

            .wa-select {
                background-color: #1E293B !important;
                color: #F8FAFC !important;
                border: 1px solid #334155 !important;
                border-radius: 8px !important;
                padding: 8px 14px !important;
                font-size: 0.85rem !important;
                font-weight: 500 !important;
                outline: none !important;
                min-width: 180px;
            }

            .wa-select:focus {
                border-color: #38BDF8 !important;
                box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.2);
            }

            .wa-btn-group {
                display: flex;
                background-color: #1E293B;
                padding: 3px;
                border-radius: 8px;
                border: 1px solid #334155;
            }

            .wa-period-btn {
                background: transparent;
                color: #94A3B8;
                border: none;
                padding: 6px 14px;
                border-radius: 6px;
                font-size: 0.75rem;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .wa-period-btn.active {
                background-color: #0284C7;
                color: #FFFFFF;
                box-shadow: 0 2px 8px rgba(2, 132, 199, 0.4);
            }

            .wa-kpi-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
                gap: 16px;
                margin-bottom: 24px;
            }

            /* Cards escuros */
            .wa-card {
                background-color: #1E293B;
                border: 1px solid #334155;
                border-radius: 10px;
                padding: 20px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                transition: border-color 0.2s ease, transform 0.2s ease;
            }

            .wa-card:hover {
                border-color: #475569;
            }

            .wa-card-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 8px;
            }

            .wa-card-title {
                font-size: 0.7rem;
                font-weight: 700;
                color: #94A3B8;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .wa-card-value {
                font-size: 1.75rem;
                font-weight: 800;
                color: #F8FAFC;
                line-height: 1.2;
            }

            .wa-card-sub {
                font-size: 0.75rem;
                color: #94A3B8;
                margin-top: 12px;
                padding-top: 10px;
                border-top: 1px solid #334155;
                display: flex;
                justify-content: space-between;
            }

            .wa-progress-bar {
                width: 100%;
                background-color: #0F172A;
                border-radius: 999px;
                height: 8px;
                overflow: hidden;
                border: 1px solid #334155;
                margin-top: 10px;
            }

            .wa-progress-fill {
                height: 100%;
                background: linear-gradient(90deg, #0ECB81 0%, #38BDF8 100%);
                border-radius: 999px;
            }

            .wa-chart-section {
                background-color: #1E293B;
                border: 1px solid #334155;
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 24px;
            }

            .wa-chart-header {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding-bottom: 14px;
                border-bottom: 1px solid #334155;
                margin-bottom: 16px;
            }

            .wa-chart-container {
                position: relative;
                height: 300px;
                width: 100%;
            }

            .wa-intelligence-grid {
                display: grid;
                grid-template-columns: 1.3fr 1fr;
                gap: 20px;
                margin-bottom: 24px;
            }

            @media (max-width: 1024px) {
                .wa-intelligence-grid {
                    grid-template-columns: 1fr;
                }
            }

            .wa-table {
                width: 100%;
                border-collapse: collapse;
                text-align: left;
                font-size: 0.8rem;
            }

            .wa-table th {
                font-size: 0.65rem;
                font-weight: 700;
                color: #94A3B8;
                text-transform: uppercase;
                padding: 10px 8px;
                border-bottom: 1px solid #334155;
            }

            .wa-table td {
                padding: 12px 8px;
                border-bottom: 1px solid #334155;
                color: #F8FAFC;
                vertical-align: middle;
            }

            .wa-table tr:hover td {
                background-color: #334155;
            }

            .wa-token-info {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .wa-token-icon {
                width: 28px;
                height: 28px;
                border-radius: 50%;
                object-fit: cover;
            }

            .wa-token-avatar {
                width: 28px;
                height: 28px;
                border-radius: 50%;
                background-color: #0284C7;
                color: #FFFFFF;
                font-weight: 800;
                font-size: 0.7rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .wa-defi-card {
                background-color: #1E293B;
                border: 1px solid #334155;
                border-radius: 8px;
                padding: 12px 14px;
                margin-bottom: 10px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                transition: border-color 0.2s ease;
            }

            .wa-defi-card:hover {
                border-color: #38BDF8;
            }

            .wa-nft-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
                gap: 16px;
            }

            .wa-nft-card {
                background-color: #1E293B;
                border: 1px solid #334155;
                border-radius: 8px;
                overflow: hidden;
                transition: transform 0.2s ease, border-color 0.2s ease;
            }

            .wa-nft-card:hover {
                border-color: #38BDF8;
                transform: translateY(-2px);
            }

            .wa-nft-thumb {
                height: 160px;
                background-color: #0F172A;
                position: relative;
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .wa-nft-thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            /* Overrides para Dark Mode */
            html.dark .wa-dashboard {
                background-color: #0B0E11 !important;
                color: #EAECEF !important;
                border: none;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            }

            html.dark .wa-header {
                border-bottom-color: #2B313A;
            }

            html.dark .wa-title-group h2 {
                color: #EAECEF;
            }

            html.dark .wa-title-sub {
                color: #848E9C;
            }

            html.dark .wa-text-main {
                color: #EAECEF;
            }

            html.dark .wa-text-sub {
                color: #848E9C;
            }

            html.dark .wa-text-accent {
                color: #38BDF8;
            }

            html.dark .wa-badge-success {
                background-color: rgba(14, 203, 129, 0.18);
                color: #0ECB81;
                border-color: rgba(14, 203, 129, 0.3);
            }

            html.dark .wa-badge-danger {
                background-color: rgba(246, 70, 93, 0.18);
                color: #F6465D;
                border-color: rgba(246, 70, 93, 0.3);
            }

            html.dark .wa-filter-label {
                color: #848E9C;
            }

            html.dark .wa-select {
                background-color: #181A20 !important;
                color: #EAECEF !important;
                border-color: #2B313A !important;
            }

            html.dark .wa-select:focus {
                border-color: #3861FB !important;
                box-shadow: 0 0 0 2px rgba(56, 97, 251, 0.2);
            }

            html.dark .wa-btn-group {
                background-color: #181A20;
                border-color: #2B313A;
            }

            html.dark .wa-period-btn {
                color: #848E9C;
            }

            html.dark .wa-period-btn.active {
                background-color: #3861FB;
                color: #FFFFFF;
                box-shadow: 0 2px 8px rgba(56, 97, 251, 0.4);
            }

            html.dark .wa-card {
                background-color: #242A32;
                border-color: #333B46;
            }

            html.dark .wa-card:hover {
                border-color: #4A5568;
            }

            html.dark .wa-card-title {
                color: #848E9C;
            }

            html.dark .wa-card-value {
                color: #EAECEF;
            }

            html.dark .wa-card-sub {
                color: #848E9C;
                border-top-color: #333B46;
            }

            html.dark .wa-progress-bar {
                background-color: #181A20;
                border-color: #2B313A;
            }

            html.dark .wa-chart-section {
                background-color: #242A32;
                border-color: #333B46;
            }

            html.dark .wa-chart-header {
                border-bottom-color: #333B46;
            }

            html.dark .wa-table th {
                color: #848E9C;
                border-bottom-color: #333B46;
            }

            html.dark .wa-table td {
                border-bottom-color: #333B46;
                color: #EAECEF;
            }

            html.dark .wa-table tr:hover td {
                background-color: #2C333E;
            }

            html.dark .wa-token-avatar {
                background-color: #3861FB;
                color: #FFFFFF;
            }

            html.dark .wa-defi-card {
                background-color: #181A20;
                border-color: #333B46;
            }

            html.dark .wa-defi-card:hover {
                border-color: #3861FB;
            }

            html.dark .wa-nft-card {
                background-color: #181A20;
                border-color: #333B46;
            }

            html.dark .wa-nft-card:hover {
                border-color: #3861FB;
            }

            html.dark .wa-nft-thumb {
                background-color: #0B0E11;
            }
        </style>
    @endpush

    <div class="wa-dashboard">

        <!-- HEADER DA PAGINA & FILTROS GLOBAIS DE TERCEIROS -->
        <div class="wa-header">
            <div class="wa-title-group">
                <div>
                    <h2>
                        <span class="wa-pulse-dot"></span>
                        Análise de Carteiras de Terceiros
                        <span class="wa-badge wa-badge-success">AUDITORIA ON-CHAIN</span>
                    </h2>
                    <div class="wa-title-sub">
                        Gestão Broad e Inspeção de Portfólio de Clientes e Endereços Externos em Tempo Real
                    </div>
                </div>
            </div>

            <!-- FILTROS CONTROLES -->
            <div class="wa-filters">
                <!-- Seletor de Carteira -->
                <div class="wa-filter-box">
                    <span class="wa-filter-label">Carteira de Terceiros</span>
                    <select wire:model.live="selectedWalletId" class="wa-select">
                        <option value="all">🌐 Todas as Carteiras (Consolidado)</option>
                        @foreach($this->wallets as $w)
                            <option value="{{ $w->id }}">{{ $w->label ?: 'Carteira' }} ({{ $w->short_address }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro de Rede -->
                <div class="wa-filter-box">
                    <span class="wa-filter-label">Rede Blockchain</span>
                    <select wire:model.live="selectedNetwork" class="wa-select" style="min-width: 160px;">
                        <option value="all">🌐 Todas as Redes</option>
                        @foreach($this->availableNetworks as $net)
                            <option value="{{ $net }}">{{ ucfirst(str_replace('-', ' ', $net)) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Período -->
                <div class="wa-filter-box">
                    <span class="wa-filter-label">Período</span>
                    <div class="wa-btn-group">
                        @foreach(['1D', '7D', '30D', 'ALL'] as $period)
                            <button wire:click="$set('selectedPeriod', '{{ $period }}')"
                                    class="wa-period-btn {{ $selectedPeriod === $period ? 'active' : '' }}">
                                {{ $period }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- CARDS KPIS (METRICAS CONSOLIDADAS) -->
        <div class="wa-kpi-grid">

            <!-- Net Worth -->
            <div class="wa-card">
                <div>
                    <div class="wa-card-header">
                        <span class="wa-card-title">Net Worth (Patrimônio)</span>
                        <span class="wa-card-title">USD</span>
                    </div>
                    <div class="wa-card-value">
                        $ {{ number_format($this->metrics['net_worth'], 2, '.', ',') }}
                    </div>
                </div>
                <div class="wa-card-sub">
                    <span>Tokens: <strong class="wa-text-main">${{ number_format($this->metrics['tokens_total'], 0) }}</strong></span>
                    <span>DeFi: <strong class="wa-text-main">${{ number_format($this->metrics['defi_total'], 0) }}</strong></span>
                    <span>NFTs: <strong class="wa-text-main">${{ number_format($this->metrics['nfts_total'], 0) }}</strong></span>
                </div>
            </div>

            <!-- P&L Total -->
            <div class="wa-card">
                <div>
                    <div class="wa-card-header">
                        <span class="wa-card-title">Lucro / Prejuízo (P&L)</span>
                        <span class="wa-badge {{ $this->metrics['pnl_usd'] >= 0 ? 'wa-badge-success' : 'wa-badge-danger' }}">
                            {{ $this->metrics['pnl_usd'] >= 0 ? '▲ +' : '▼ ' }}{{ number_format($this->metrics['pnl_percentage'], 2) }}%
                        </span>
                    </div>
                    <div class="wa-card-value" style="color: {{ $this->metrics['pnl_usd'] >= 0 ? '#0ECB81' : '#F6465D' }};">
                        {{ $this->metrics['pnl_usd'] >= 0 ? '+$ ' : '-$ ' }}{{ number_format(abs($this->metrics['pnl_usd']), 2, '.', ',') }}
                    </div>
                </div>
                <div class="wa-card-sub">
                    <span>Retorno estimado no período: <strong class="wa-text-main">{{ $selectedPeriod }}</strong></span>
                </div>
            </div>

            <!-- Health Score -->
            <div class="wa-card">
                <div>
                    <div class="wa-card-header">
                        <span class="wa-card-title">Health Score & Risco</span>
                        <span class="wa-text-accent" style="font-size: 0.7rem; font-weight: 800;">BAIXO RISCO</span>
                    </div>
                    <div class="wa-card-value">
                        {{ $this->metrics['health_score'] }} <span style="font-size: 0.9rem; font-weight: 500;" class="wa-text-sub">/ 100</span>
                    </div>
                </div>
                <div>
                    <div class="wa-progress-bar">
                        <div class="wa-progress-fill" style="width: {{ $this->metrics['health_score'] }}%;"></div>
                    </div>
                    <div class="wa-card-sub" style="border: none; padding-top: 6px; margin-top: 0;">
                        <span>Proporção de Alta Liquidez</span>
                    </div>
                </div>
            </div>

            <!-- Gás Total Gasto -->
            <div class="wa-card">
                <div>
                    <div class="wa-card-header">
                        <span class="wa-card-title">Gás Total Gasto</span>
                        <span class="wa-card-title">Fees</span>
                    </div>
                    <div class="wa-card-value">
                        $ {{ number_format($this->metrics['gas_spent_usd'], 2, '.', ',') }}
                    </div>
                </div>
                <div class="wa-card-sub">
                    <span>Taxas gastas em transações na rede</span>
                </div>
            </div>

        </div>

        <!-- SECAO CENTRAL: GRAFICO DE EVOLUCAO TEMPORAL -->
        <div class="wa-chart-section">
            <div class="wa-chart-header">
                <div>
                    <h3 class="wa-text-main" style="font-size: 1rem; font-weight: 700; margin: 0;">Evolução Patrimonial do Portfólio de Terceiros</h3>
                    <div class="wa-text-sub" style="font-size: 0.75rem; margin-top: 2px;">Histórico do Patrimônio Líquido vs Benchmarks</div>
                </div>

                <div class="wa-text-sub" style="display: flex; align-items: center; gap: 14px; font-size: 0.75rem;">
                    <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
                        <input type="checkbox" wire:model.live="compareBtc" style="accent-color: #38BDF8;">
                        <span>Benchmark BTC</span>
                    </label>
                </div>
            </div>

            <!-- DATA HOLDER ELEMENT FOR LIVEWIRE COMPONENT STATE RE-RENDERING -->
            <div class="wa-chart-container" 
                 id="chartDataContainer" 
                 data-chart='@json($this->chartData)' 
                 data-compare-btc="{{ $this->compareBtc ? 'true' : 'false' }}">
                <canvas id="portfolioChart"></canvas>
            </div>
        </div>

        <!-- SECAO INFERIOR: TOKENS MAIS COMPRADOS E POSICOES DEFI -->
        <div class="wa-intelligence-grid">

            <!-- BLOCO ESQUERDO: TOKENS MAIS COMPRADOS (BUY MOMENTUM & DCA) -->
            <div class="wa-card" style="justify-content: flex-start;">
                <div class="wa-chart-header" style="margin-bottom: 12px; padding-bottom: 10px;">
                    <div>
                        <h3 class="wa-text-main" style="font-size: 0.95rem; font-weight: 700; margin: 0;">Tokens Mais Comprados (Buy Momentum)</h3>
                        <div class="wa-text-sub" style="font-size: 0.7rem;">Aportes de Entrada e Preço Médio (DCA)</div>
                    </div>
                    <span class="wa-badge wa-badge-success">TOP COMPRAS</span>
                </div>

                <div style="overflow-x: auto;">
                    <table class="wa-table">
                        <thead>
                            <tr>
                                <th>Ativo</th>
                                <th>Rede</th>
                                <th style="text-align: right;">Volume Alocado</th>
                                <th style="text-align: right;">Preço DCA</th>
                                <th style="text-align: center;">Frequência Compras</th>
                                <th style="text-align: right;">Tendência 24h</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($this->topBoughtTokens as $t)
                                <tr>
                                    <td>
                                        <div class="wa-token-info">
                                            @if($t['logo_url'])
                                                <img src="{{ $t['logo_url'] }}" class="wa-token-icon" alt="{{ $t['symbol'] }}">
                                            @else
                                                <div class="wa-token-avatar">{{ substr($t['symbol'], 0, 2) }}</div>
                                            @endif
                                            <div>
                                                <strong class="wa-text-main" style="display: block;">{{ $t['symbol'] }}</strong>
                                                <span class="wa-text-sub" style="font-size: 0.65rem;">{{ $t['name'] }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="wa-badge wa-btn-group" style="padding: 2px 6px;">
                                            {{ $t['network'] }}
                                        </span>
                                    </td>
                                    <td class="wa-text-main" style="text-align: right; font-weight: 700;">
                                        $ {{ number_format($t['allocated_usd'], 2) }}
                                    </td>
                                    <td class="wa-text-sub" style="text-align: right;">
                                        $ {{ number_format($t['dca_price'], 2) }}
                                    </td>
                                    <td style="text-align: center;">
                                        <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                                            <div class="wa-progress-bar" style="width: 70px; margin: 0;">
                                                <div class="wa-progress-fill" style="width: {{ $t['buy_ratio'] }}%; background: #0ECB81;"></div>
                                            </div>
                                            <span style="font-size: 0.7rem; font-weight: 800; color: #0ECB81;">{{ $t['buy_ratio'] }}%</span>
                                        </div>
                                    </td>
                                    <td style="text-align: right; font-weight: 800; color: #0ECB81;">
                                        +{{ number_format($t['price_change_24h'], 2) }}%
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="wa-text-sub" style="text-align: center; padding: 20px;">Nenhum token encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- BLOCO DIREITO: POSICOES DEFI DA CARTEIRA -->
            <div class="wa-card" style="justify-content: flex-start;">
                <div class="wa-chart-header" style="margin-bottom: 12px; padding-bottom: 10px;">
                    <div>
                        <h3 class="wa-text-main" style="font-size: 0.95rem; font-weight: 700; margin: 0;">Posições DeFi de Terceiros</h3>
                        <div class="wa-text-sub" style="font-size: 0.7rem;">Lending, Staking e Pools</div>
                    </div>
                    <span class="wa-text-sub" style="font-size: 0.75rem;">Total: <strong class="wa-text-main">${{ number_format($this->metrics['defi_total'], 2) }}</strong></span>
                </div>

                <div style="max-height: 320px; overflow-y: auto; padding-right: 4px;">
                    @forelse($this->defiPositions as $d)
                        <div class="wa-defi-card">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                @if($d->protocol_logo_url)
                                    <img src="{{ $d->protocol_logo_url }}" style="width: 32px; height: 32px; border-radius: 50%;" alt="{{ $d->protocol_name }}">
                                @else
                                    <div class="wa-token-avatar" style="width: 32px; height: 32px; font-weight: 800;">
                                        {{ substr($d->protocol_name, 0, 2) }}
                                    </div>
                                @endif
                                <div>
                                    <strong class="wa-text-main" style="font-size: 0.85rem; display: block;">{{ $d->protocol_name }}</strong>
                                    <div style="display: flex; align-items: center; gap: 6px; margin-top: 2px;">
                                        <span class="wa-text-accent" style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase;">{{ $d->position_type }}</span>
                                        @if($d->apr)
                                            <span style="font-size: 0.65rem; color: #0ECB81; font-weight: 800;">APR {{ number_format($d->apr, 2) }}%</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <strong class="wa-text-main" style="font-size: 0.85rem; display: block;">$ {{ number_format($d->total_value_usd, 2) }}</strong>
                                @if($d->rewards_value_usd > 0)
                                    <span style="font-size: 0.65rem; color: #0ECB81; display: block;">+ ${{ number_format($d->rewards_value_usd, 2) }} Recompensas</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="wa-text-sub" style="padding: 20px; text-align: center; font-size: 0.8rem;">Nenhuma posição DeFi cadastrada.</div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- SECAO DE NFTS DA CARTEIRA DE TERCEIROS -->
        <div class="wa-card">
            <div class="wa-chart-header" style="margin-bottom: 16px; padding-bottom: 10px;">
                <div>
                    <h3 class="wa-text-main" style="font-size: 1rem; font-weight: 700; margin: 0;">Inventário de NFTs de Terceiros</h3>
                    <div class="wa-text-sub" style="font-size: 0.75rem;">Coleções e Valor Estimado de Floor Price</div>
                </div>
                <span class="wa-text-sub" style="font-size: 0.75rem;">Total em NFTs: <strong class="wa-text-main">${{ number_format($this->metrics['nfts_total'], 2) }}</strong></span>
            </div>

            <div class="wa-nft-grid">
                @forelse($this->nfts as $nft)
                    <div class="wa-nft-card">
                        <div class="wa-nft-thumb">
                            @if($nft->image_url)
                                <img src="{{ $nft->image_url }}" alt="{{ $nft->name }}">
                            @else
                                <div class="wa-text-sub" style="text-align: center; font-size: 0.75rem;">
                                    <div style="font-size: 1.5rem; margin-bottom: 4px;">🖼️</div>
                                    Sem Imagem
                                </div>
                            @endif
                            <span class="wa-badge" style="position: absolute; top: 8px; right: 8px; background: rgba(0,0,0,0.75); color: #EAECEF;">
                                #{{ $nft->token_id }}
                            </span>
                        </div>
                        <div style="padding: 12px;">
                            <strong class="wa-text-main" style="font-size: 0.8rem; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ $nft->collection_name }}
                            </strong>
                            <div class="wa-header" style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px; padding-top: 8px; padding-bottom: 0; margin-bottom: 0;">
                                <span class="wa-text-sub" style="font-size: 0.65rem;">Floor Price:</span>
                                <strong style="font-size: 0.85rem; color: #0ECB81;">$ {{ number_format($nft->estimated_value_usd, 2) }}</strong>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="wa-text-sub" style="grid-column: 1 / -1; text-align: center; padding: 30px; font-size: 0.8rem;">
                        Nenhum NFT encontrado nas carteiras selecionadas.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- SCRIPT DE INTERATIVIDADE E EVENTOS COMPATÍVEIS COM LIVEWIRE V3 E FILAMENT V3 -->
    <script>
        function renderPortfolioChart() {
            const ctx = document.getElementById('portfolioChart');
            const container = document.getElementById('chartDataContainer');
            if (!ctx || !container) return;

            let chartData = { labels: [], portfolio: [], btc_benchmark: [] };
            let compareBtc = true;

            try {
                chartData = JSON.parse(container.dataset.chart || '{}');
                compareBtc = container.dataset.compareBtc === 'true';
            } catch (e) {
                console.error("Error parsing chart data:", e);
                return;
            }

            if (window.myPortfolioChartInstance) {
                window.myPortfolioChartInstance.destroy();
            }

            const canvasCtx = ctx.getContext('2d');
            const gradient = canvasCtx.createLinearGradient(0, 0, 0, 280);
            gradient.addColorStop(0, 'rgba(14, 203, 129, 0.35)');
            gradient.addColorStop(1, 'rgba(14, 203, 129, 0.0)');

            const datasets = [{
                label: 'Portfólio de Terceiros (USD)',
                data: chartData.portfolio || [],
                borderColor: '#0ECB81',
                borderWidth: 2.5,
                backgroundColor: gradient,
                fill: true,
                tension: 0.35,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#0ECB81',
                pointHoverBorderColor: '#FFFFFF',
                pointHoverBorderWidth: 2,
            }];

            if (compareBtc && chartData.btc_benchmark) {
                datasets.push({
                    label: 'Benchmark BTC (Relativo)',
                    data: chartData.btc_benchmark,
                    borderColor: '#38BDF8',
                    borderWidth: 1.8,
                    borderDash: [5, 5],
                    fill: false,
                    tension: 0.3,
                    pointRadius: 0,
                });
            }

            window.myPortfolioChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels || [],
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            align: 'end',
                            labels: {
                                color: '#94A3B8',
                                font: { size: 11, weight: '600' },
                                boxWidth: 12,
                            }
                        },
                        tooltip: {
                            backgroundColor: '#0F172A',
                            borderColor: '#334155',
                            borderWidth: 1,
                            titleColor: '#F8FAFC',
                            bodyColor: '#F8FAFC',
                            padding: 12,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': $' + context.parsed.y.toLocaleString('en-US', {minimumFractionDigits: 2});
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { color: 'rgba(51, 65, 85, 0.3)', drawBorder: false },
                            ticks: { color: '#94A3B8', font: { size: 10 } }
                        },
                        y: {
                            grid: { color: 'rgba(51, 65, 85, 0.3)', drawBorder: false },
                            ticks: {
                                color: '#94A3B8',
                                font: { size: 10 },
                                callback: function(value) {
                                    return '$' + (value >= 1000 ? (value/1000).toFixed(0) + 'k' : value);
                                }
                            }
                        }
                    }
                }
            });
        }

        if (!window.__portfolioChartInitialized) {
            window.__portfolioChartInitialized = true;

            document.addEventListener('DOMContentLoaded', renderPortfolioChart);
            document.addEventListener('livewire:init', renderPortfolioChart);
            document.addEventListener('livewire:navigated', renderPortfolioChart);

            document.addEventListener('livewire:init', () => {
                if (window.Livewire) {
                    Livewire.hook('commit', ({ succeed }) => {
                        succeed(() => {
                            setTimeout(renderPortfolioChart, 50);
                        });
                    });
                }
            });
        }
    </script>
</x-filament-panels::page>