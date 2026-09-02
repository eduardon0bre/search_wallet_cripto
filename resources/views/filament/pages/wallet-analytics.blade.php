<x-filament-panels::page>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    @endpush

    @push('styles')
        <style>
            .wa-dashboard {
                background-color: #16171A !important;
                color: #F3F4F6 !important;
                font-family: 'Inter', system-ui, -apple-system, sans-serif;
                border-radius: 12px;
                padding: 24px;
                margin-top: -10px;
                border: 1px solid #26272B;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
            }

            .wa-header {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                padding-bottom: 20px;
                border-bottom: 1px solid #2D2F36;
                margin-bottom: 24px;
            }

            .wa-title-group h2 {
                font-size: 1.5rem;
                font-weight: 800;
                color: #F3F4F6;
                margin: 0;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .wa-title-sub {
                font-size: 0.8rem;
                color: #9CA3AF;
                margin-top: 4px;
            }

            .wa-text-main {
                color: #F3F4F6;
            }

            .wa-text-sub {
                color: #9CA3AF;
            }

            .wa-text-accent {
                color: #38BDF8;
            }

            .wa-pulse-dot {
                width: 10px;
                height: 10px;
                background-color: #10B981;
                border-radius: 50%;
                display: inline-block;
                box-shadow: 0 0 10px #10B981;
            }

            .wa-spin {
                animation: waSpin 1s linear infinite;
            }

            @keyframes waSpin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
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

            .wa-badge-sky {
                background-color: rgba(56, 189, 248, 0.12);
                color: #38BDF8;
                border: 1px solid rgba(56, 189, 248, 0.3);
            }

            .wa-badge-success {
                background-color: rgba(16, 185, 129, 0.15);
                color: #10B981;
                border: 1px solid rgba(16, 185, 129, 0.35);
            }

            .wa-badge-danger {
                background-color: rgba(239, 68, 68, 0.15);
                color: #EF4444;
                border: 1px solid rgba(239, 68, 68, 0.35);
            }

            .wa-badge-purple {
                background-color: rgba(168, 85, 247, 0.15);
                color: #C084FC;
                border: 1px solid rgba(168, 85, 247, 0.35);
            }

            .wa-badge-amber {
                background-color: rgba(245, 158, 11, 0.15);
                color: #FBBF24;
                border: 1px solid rgba(245, 158, 11, 0.35);
            }

            .wa-badge-neutral {
                background-color: rgba(161, 161, 170, 0.15);
                color: #9CA3AF;
                border: 1px solid rgba(161, 161, 170, 0.3);
            }

            /* BARRA DE FILTROS PRINCIPAL */
            .wa-filter-card {
                background-color: #202125;
                border: 1px solid #2D2F36;
                border-radius: 12px;
                padding: 20px;
                margin-bottom: 24px;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
            }

            .wa-filter-card-header {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding-bottom: 14px;
                border-bottom: 1px solid #2D2F36;
                margin-bottom: 18px;
            }

            .wa-filter-card-title {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 0.85rem;
                font-weight: 700;
                color: #F3F4F6;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .wa-filter-grid {
                display: grid;
                grid-template-columns: 2fr 1.6fr 1fr 1.3fr auto;
                gap: 16px;
                align-items: flex-end;
            }

            @media (max-width: 1280px) {
                .wa-filter-grid {
                    grid-template-columns: 1fr 1fr;
                }
            }

            @media (max-width: 768px) {
                .wa-filter-grid {
                    grid-template-columns: 1fr;
                }
            }

            .wa-filter-item {
                display: flex;
                flex-direction: column;
                gap: 6px;
            }

            .wa-filter-label {
                font-size: 0.68rem;
                font-weight: 700;
                color: #9CA3AF;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                display: flex;
                align-items: center;
                gap: 6px;
            }

            .wa-filter-icon {
                width: 15px;
                height: 15px;
                color: #38BDF8;
                flex-shrink: 0;
            }

            .wa-select-custom {
                width: 100%;
                background-color: #18191D !important;
                color: #F3F4F6 !important;
                border: 1px solid #2D2F36 !important;
                border-radius: 8px !important;
                padding: 8px 12px !important;
                font-size: 0.82rem !important;
                font-weight: 600 !important;
                outline: none !important;
                transition: all 0.2s ease;
                cursor: pointer;
                height: 38px;
            }

            .wa-select-custom:focus {
                border-color: #38BDF8 !important;
                box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.25) !important;
            }

            .wa-period-group {
                display: inline-flex;
                background-color: #18191D;
                padding: 3px;
                border-radius: 8px;
                border: 1px solid #2D2F36;
                width: 100%;
                height: 38px;
                align-items: center;
            }

            .wa-period-btn {
                flex: 1;
                background: transparent;
                color: #9CA3AF;
                border: none;
                padding: 6px 4px;
                border-radius: 6px;
                font-size: 0.72rem;
                font-weight: 700;
                cursor: pointer;
                text-align: center;
                transition: all 0.2s ease;
                white-space: nowrap;
            }

            .wa-period-btn:hover {
                color: #F3F4F6;
                background-color: rgba(255, 255, 255, 0.06);
            }

            .wa-period-btn.active {
                background-color: #0284C7;
                color: #FFFFFF;
                box-shadow: 0 2px 8px rgba(2, 132, 199, 0.4);
            }

            .wa-btn-refresh {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                background: linear-gradient(135deg, #0284C7 0%, #0369A1 100%);
                color: #FFFFFF;
                border: 1px solid #38BDF8;
                border-radius: 8px;
                padding: 0 16px;
                height: 38px;
                font-size: 0.8rem;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.2s ease;
                white-space: nowrap;
            }

            .wa-btn-refresh:hover:not(:disabled) {
                background: linear-gradient(135deg, #0369A1 0%, #075985 100%);
                box-shadow: 0 4px 12px rgba(2, 132, 199, 0.35);
            }

            .wa-btn-refresh:disabled {
                opacity: 0.6;
                cursor: not-allowed;
            }

            .wa-filter-meta-bar {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding-top: 14px;
                margin-top: 16px;
                border-top: 1px dashed #2D2F36;
                font-size: 0.75rem;
                color: #9CA3AF;
            }

            .wa-filter-meta-item {
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .wa-mono-badge {
                padding: 4px 10px;
                border-radius: 6px;
                font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
                font-weight: 600;
                background-color: #18191D;
                border: 1px solid #2D2F36;
                color: #38BDF8;
            }

            /* KPIS E CARDS */
            .wa-kpi-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 16px;
                margin-bottom: 24px;
            }

            .wa-card {
                background-color: #202125;
                border: 1px solid #2D2F36;
                border-radius: 10px;
                padding: 18px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                transition: border-color 0.2s ease, transform 0.2s ease;
            }

            .wa-card:hover {
                border-color: #3E414B;
            }

            .wa-card-sky {
                border-left: 4px solid #0284C7;
            }

            .wa-card-emerald {
                border-left: 4px solid #10B981;
            }

            .wa-card-rose {
                border-left: 4px solid #EF4444;
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
                color: #9CA3AF;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .wa-card-value {
                font-size: 1.5rem;
                font-weight: 800;
                color: #F3F4F6;
                line-height: 1.2;
            }

            .wa-card-sub {
                font-size: 0.72rem;
                color: #9CA3AF;
                margin-top: 10px;
                padding-top: 8px;
                border-top: 1px solid #2D2F36;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            /* SUB-METRICAS BAR */
            .wa-submetrics-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 12px;
                margin-bottom: 24px;
            }

            .wa-submetric-box {
                background-color: #202125;
                border: 1px solid #2D2F36;
                border-radius: 8px;
                padding: 12px 14px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .wa-progress-bar {
                width: 100%;
                background-color: #18191D;
                border-radius: 999px;
                height: 6px;
                overflow: hidden;
                border: 1px solid #2D2F36;
                margin-top: 6px;
            }

            .wa-progress-fill {
                height: 100%;
                background: linear-gradient(90deg, #10B981 0%, #38BDF8 100%);
                border-radius: 999px;
            }

            /* GRAFICO PATRIMONIAL */
            .wa-chart-section {
                background-color: #202125;
                border: 1px solid #2D2F36;
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 24px;
                position: relative;
            }

            .wa-chart-header {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding-bottom: 14px;
                border-bottom: 1px solid #2D2F36;
                margin-bottom: 16px;
            }

            .wa-chart-container {
                position: relative;
                height: 350px;
                width: 100%;
            }

            .wa-loading-overlay {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(22, 23, 26, 0.9);
                backdrop-filter: blur(4px);
                -webkit-backdrop-filter: blur(4px);
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                gap: 12px;
                z-index: 30;
                border-radius: 10px;
                color: #38BDF8;
                font-weight: 600;
                font-size: 0.85rem;
            }

            .wa-section-card {
                background-color: #202125;
                border: 1px solid #2D2F36;
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 24px;
            }

            .wa-table-scroll {
                max-height: 400px;
                overflow-y: auto;
                border-radius: 8px;
                border: 1px solid #2D2F36;
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
                color: #9CA3AF;
                text-transform: uppercase;
                padding: 10px 14px;
                border-bottom: 1px solid #2D2F36;
                background-color: #18191D;
                position: sticky;
                top: 0;
                z-index: 10;
            }

            .wa-table td {
                padding: 12px 14px;
                border-bottom: 1px solid #2D2F36;
                background-color: #202125;
                color: #F3F4F6;
                vertical-align: middle;
            }

            .wa-table tr:hover td {
                background-color: #282A30;
            }

            .wa-token-info {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .wa-token-icon {
                width: 28px;
                height: 28px;
                border-radius: 50%;
                object-fit: cover;
                flex-shrink: 0;
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
                flex-shrink: 0;
            }

            .wa-mono-val {
                font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
                font-size: 0.8rem;
            }

            /* TABS NAVIGATION */
            .wa-tabs-nav {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                margin-bottom: 16px;
                border-bottom: 1px solid #2D2F36;
                padding-bottom: 10px;
            }

            .wa-tab-btn {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background: transparent;
                border: 1px solid transparent;
                color: #9CA3AF;
                padding: 8px 16px;
                border-radius: 8px;
                font-size: 0.8rem;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .wa-tab-btn:hover {
                color: #F3F4F6;
                background-color: #18191D;
            }

            .wa-tab-btn.active {
                background-color: #0284C7;
                color: #FFFFFF;
                border-color: #38BDF8;
                box-shadow: 0 2px 8px rgba(2, 132, 199, 0.4);
            }

            .wa-defi-card {
                background-color: #18191D;
                border: 1px solid #2D2F36;
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
                background-color: #18191D;
                border: 1px solid #2D2F36;
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
                background-color: #121315;
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

            .wa-pagination-container {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 12px;
                margin-top: 20px;
                padding-top: 16px;
                border-top: 1px solid #2D2F36;
            }

            .wa-pagination-btn, .wa-pagination-num {
                background-color: #18191D;
                color: #F3F4F6;
                border: 1px solid #2D2F36;
                border-radius: 6px;
                padding: 6px 14px;
                font-size: 0.8rem;
                font-weight: 600;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                transition: all 0.2s ease;
                user-select: none;
            }

            .wa-pagination-btn:hover:not(:disabled), .wa-pagination-num:hover:not(.active) {
                background-color: #282A30;
                border-color: #38BDF8;
                color: #38BDF8;
            }

            .wa-pagination-btn:disabled {
                opacity: 0.35;
                cursor: not-allowed;
                border-color: #2D2F36;
                color: #6B7280;
                background-color: #18191D;
            }

            .wa-pagination-num.active {
                background-color: #0284C7;
                border-color: #38BDF8;
                color: #FFFFFF;
                font-weight: 700;
            }

            .wa-alert-warning {
                padding: 24px;
                border-radius: 10px;
                background-color: rgba(245, 158, 11, 0.12);
                border: 1px solid rgba(245, 158, 11, 0.35);
                color: #FCD34D;
                text-align: center;
                margin-bottom: 24px;
            }

            /* DARK MODE HARMONIZATION */
            html.dark .wa-dashboard {
                background-color: #16171A !important;
                color: #F3F4F6 !important;
                border-color: #26272B !important;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            }

            html.dark .wa-header {
                border-bottom-color: #2D2F36;
            }

            html.dark .wa-title-group h2 {
                color: #F3F4F6;
            }

            html.dark .wa-filter-card,
            html.dark .wa-section-card,
            html.dark .wa-card,
            html.dark .wa-chart-section,
            html.dark .wa-submetric-box {
                background-color: #202125;
                border-color: #2D2F36;
            }

            html.dark .wa-filter-card-header,
            html.dark .wa-chart-header,
            html.dark .wa-tabs-nav,
            html.dark .wa-card-sub,
            html.dark .wa-filter-meta-bar,
            html.dark .wa-pagination-container {
                border-color: #2D2F36;
            }

            html.dark .wa-select-custom,
            html.dark .wa-period-group,
            html.dark .wa-mono-badge,
            html.dark .wa-defi-card,
            html.dark .wa-nft-card,
            html.dark .wa-table th,
            html.dark .wa-pagination-btn,
            html.dark .wa-pagination-num {
                background-color: #18191D !important;
                color: #F3F4F6 !important;
                border-color: #2D2F36 !important;
            }

            html.dark .wa-pagination-btn:disabled {
                opacity: 0.35;
                cursor: not-allowed;
                border-color: #2D2F36 !important;
                color: #6B7280 !important;
                background-color: #18191D !important;
            }

            html.dark .wa-period-btn.active,
            html.dark .wa-tab-btn.active,
            html.dark .wa-pagination-num.active {
                background-color: #0284C7;
                border-color: #38BDF8;
                color: #FFFFFF;
                box-shadow: 0 2px 8px rgba(2, 132, 199, 0.4);
            }

            html.dark .wa-btn-refresh {
                background: linear-gradient(135deg, #0284C7 0%, #0369A1 100%);
                border-color: #38BDF8;
                box-shadow: 0 2px 8px rgba(2, 132, 199, 0.3);
            }

            html.dark .wa-table td {
                background-color: #202125 !important;
                border-bottom-color: #2D2F36;
                color: #F3F4F6;
            }

            html.dark .wa-table tr:hover td {
                background-color: #282A30 !important;
            }
        </style>
    @endpush

    @php
        $chartResult = $this->chartData;
        $hasData = $chartResult['has_data'] ?? false;
        $stats = $chartResult['stats'] ?? [];
        $symbol = $this->getCurrencySymbol();
        $activeAddr = $this->getActiveAddress();
        $selectedWallet = $this->selectedWallet;
        $tokens = $this->tokenBalances;
        $defiPositions = $this->defiPositions;
        $nfts = $this->nfts;
        $metrics = $this->metrics;
        $topBoughtTokens = $this->topBoughtTokens;
        $availableNetworks = $this->availableNetworks;
    @endphp

    <div class="wa-dashboard">
        <div class="wa-filter-card">
            <div class="wa-filter-card-header">
                <div class="wa-filter-card-title">
                    <x-heroicon-o-adjustments-horizontal class="wa-filter-icon" />
                    <span>Controles e Filtros Globais</span>
                </div>
            </div>

            <div class="wa-filter-grid">
                <!-- Seletor de Carteira -->
                <div class="wa-filter-item">
                    <label class="wa-filter-label">
                        <x-heroicon-o-wallet class="wa-filter-icon" />
                        Carteira Web3
                    </label>
                    <select wire:model.live="selectedWalletId" class="wa-select-custom">
                        <option value="all">🌐 Todas as Carteiras (Visão Consolidada)</option>
                        @foreach ($this->wallets as $w)
                            <option value="{{ $w->id }}">{{ $w->label ?: 'Carteira' }} — {{ $w->wallet_address }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Período Histórico -->
                <div class="wa-filter-item">
                    <span class="wa-filter-label">
                        <x-heroicon-o-calendar-days class="wa-filter-icon" />
                        Período Histórico
                    </span>
                    <div class="wa-period-group">
                        @foreach (['hour' => '1H', 'day' => '24H', 'week' => '7D', 'month' => '30D', 'year' => '1A', 'max' => 'MAX'] as $key => $lbl)
                            <button
                                wire:click="setPeriod('{{ $key }}')"
                                wire:loading.attr="disabled"
                                type="button"
                                class="wa-period-btn {{ $chartType === $key ? 'active' : '' }}"
                            >
                                {{ $lbl }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Moeda Base (Prioridade) -->
                <div class="wa-filter-item">
                    <span class="wa-filter-label">
                        <x-heroicon-o-currency-dollar class="wa-filter-icon" />
                        Moeda Base
                    </span>
                    <select wire:model.live="currency" class="wa-select-custom">
                        <option value="usd">USD ($)</option>
                        <option value="brl">BRL (R$)</option>
                        <option value="eur">EUR (€)</option>
                        <option value="btc">BTC (₿)</option>
                        <option value="eth">ETH (Ξ)</option>
                    </select>
                </div>

                <!-- Composição / Posições -->
                <div class="wa-filter-item">
                    <span class="wa-filter-label">
                        <x-heroicon-o-rectangle-stack class="wa-filter-icon" />
                        Composição
                    </span>
                    <select wire:model.live="positionsFilter" class="wa-select-custom">
                        <option value="no_filter">Todos (Tokens + DeFi)</option>
                        <option value="only_simple">Apenas Tokens</option>
                        <option value="only_complex">Apenas DeFi</option>
                    </select>
                </div>

                <!-- Botão Atualizar / Sincronizar Zerion -->
                <div class="wa-filter-item">
                    <button
                        wire:click="clearCacheAndReload"
                        wire:loading.attr="disabled"
                        type="button"
                        class="wa-btn-refresh"
                        title="Limpar Cache e Sincronizar da Zerion API"
                    >
                        <x-heroicon-o-arrow-path wire:loading.class="wa-spin" wire:target="clearCacheAndReload" class="w-4 h-4" />
                        <span>Atualizar</span>
                    </button>
                </div>
            </div>

            <!-- Sub-barra de Metadados / Resumo da Carteira -->
            @if ($selectedWallet)
                <div class="wa-filter-meta-bar">
                    <div class="wa-filter-meta-item">
                    </div>
                    <div class="wa-filter-meta-item">
                        <span>Tokens em Carteira: <strong class="wa-text-main" style="color: #38BDF8;">{{ $tokens->count() }} ativos</strong></span>
                        <span style="opacity: 0.4;">|</span>
                        <span>Saldo Total em Banco: <strong style="color: #10B981;">${{ number_format((float) ($tokens->sum('balance_usd') ?? 0), 2, ',', '.') }}</strong></span>
                    </div>
                </div>
            @endif
        </div>

        @if (!$hasData && !empty($chartResult['error']))
            <div class="wa-alert-warning">
                <x-heroicon-o-exclamation-circle style="width: 36px; height: 36px; margin: 0 auto 10px auto; color: #F59E0B;" />
                <h3 style="font-size: 1rem; font-weight: 700; margin: 0 0 6px 0; color: #FCD34D;">Não foi possível carregar os dados históricos</h3>
                <div style="font-size: 0.85rem; color: #E2E8F0;">{{ $chartResult['error'] }}</div>
            </div>
        @endif

        <!-- 3. KPIS CONSOLIDADOS DO PERÍODO & PATRIMÔNIO -->
        @if (!empty($stats))
            <div class="wa-kpi-grid">
                <!-- 1. Patrimônio Atual -->
                <div class="wa-card wa-card-sky">
                    <div class="wa-card-header">
                        <span class="wa-card-title">Patrimônio Atual</span>
                        <span class="wa-badge wa-badge-sky">{{ strtoupper($currency) }}</span>
                    </div>
                    <div class="wa-card-value" style="color: #38BDF8;">
                        {{ $symbol }} {{ number_format((float) ($stats['current_value'] ?? 0), 2, ',', '.') }}
                    </div>
                    <div class="wa-card-sub">
                        Cotação final no período selecionado
                    </div>
                </div>

                <!-- 2. PnL do Período -->
                <div class="wa-card {{ ($stats['trend'] ?? 'positive') === 'positive' ? 'wa-card-emerald' : 'wa-card-rose' }}">
                    <div class="wa-card-header">
                        <span class="wa-card-title">PnL do Período</span>
                        <span class="wa-badge {{ ($stats['trend'] ?? 'positive') === 'positive' ? 'wa-badge-success' : 'wa-badge-danger' }}">
                            {{ ($stats['trend'] ?? 'positive') === 'positive' ? '▲ +' : '▼ ' }}{{ number_format((float) ($stats['change_percent'] ?? 0), 2, ',', '.') }}%
                        </span>
                    </div>
                    <div class="wa-card-value" style="color: {{ ($stats['trend'] ?? 'positive') === 'positive' ? '#10B981' : '#EF4444' }};">
                        {{ ($stats['change_value'] ?? 0) >= 0 ? '+' : '-' }}{{ $symbol }} {{ number_format(abs((float) ($stats['change_value'] ?? 0)), 2, ',', '.') }}
                    </div>
                    <div class="wa-card-sub">
                        Variação de lucro/prejuízo no período
                    </div>
                </div>

                <!-- 3. Patrimônio Inicial -->
                <div class="wa-card">
                    <div class="wa-card-header">
                        <span class="wa-card-title">Patrimônio Inicial</span>
                    </div>
                    <div class="wa-card-value">
                        {{ $symbol }} {{ number_format((float) ($stats['start_value'] ?? 0), 2, ',', '.') }}
                    </div>
                    <div class="wa-card-sub">
                        Início da série temporal
                    </div>
                </div>

                <!-- 4. ATH do Período -->
                <div class="wa-card">
                    <div class="wa-card-header">
                        <span class="wa-card-title">Máxima (ATH)</span>
                        <x-heroicon-m-arrow-trending-up style="width: 18px; height: 18px; color: #10B981;" />
                    </div>
                    <div class="wa-card-value">
                        {{ $symbol }} {{ number_format((float) ($stats['max_value'] ?? 0), 2, ',', '.') }}
                    </div>
                    <div class="wa-card-sub" title="{{ $stats['max_date'] ?? '-' }}">
                        {{ $stats['max_date'] ?? '-' }}
                    </div>
                </div>

                <!-- 5. ATL do Período -->
                <div class="wa-card">
                    <div class="wa-card-header">
                        <span class="wa-card-title">Mínima (ATL)</span>
                        <x-heroicon-m-arrow-trending-down style="width: 18px; height: 18px; color: #EF4444;" />
                    </div>
                    <div class="wa-card-value">
                        {{ $symbol }} {{ number_format((float) ($stats['min_value'] ?? 0), 2, ',', '.') }}
                    </div>
                    <div class="wa-card-sub" title="{{ $stats['min_date'] ?? '-' }}">
                        {{ $stats['min_date'] ?? '-' }}
                    </div>
                </div>
            </div>
        @endif

        <!-- 4. SUB-METRICAS DE COMPOSICAO (BANCO LOCAL) -->
        <div class="wa-submetrics-grid">
            <div class="wa-submetric-box">
                <div>
                    <span class="wa-card-title" style="display: block;">Tokens</span>
                    <strong class="wa-text-main" style="font-size: 1.1rem;">${{ number_format($metrics['tokens_total'], 2, ',', '.') }}</strong>
                </div>
                <x-heroicon-o-circle-stack style="width: 24px; height: 24px; color: #38BDF8;" />
            </div>

            <div class="wa-submetric-box">
                <div>
                    <span class="wa-card-title" style="display: block;">DeFi</span>
                    <strong class="wa-text-main" style="font-size: 1.1rem;">${{ number_format($metrics['defi_total'], 2, ',', '.') }}</strong>
                </div>
                <x-heroicon-o-building-library style="width: 24px; height: 24px; color: #10B981;" />
            </div>

            <div class="wa-submetric-box">
                <div>
                    <span class="wa-card-title" style="display: block;">NFTs</span>
                    <strong class="wa-text-main" style="font-size: 1.1rem;">${{ number_format($metrics['nfts_total'], 2, ',', '.') }}</strong>
                </div>
                <x-heroicon-o-photo style="width: 24px; height: 24px; color: #F59E0B;" />
            </div>

            <div class="wa-submetric-box">
                <div style="width: 100%;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="wa-card-title">Health Score</span>
                        <strong class="wa-text-accent" style="font-size: 0.85rem;">{{ $metrics['health_score'] }}/100</strong>
                    </div>
                    <div class="wa-progress-bar">
                        <div class="wa-progress-fill" style="width: {{ $metrics['health_score'] }}%;"></div>
                    </div>
                </div>
            </div>

            <div class="wa-submetric-box">
                <div>
                    <span class="wa-card-title" style="display: block;">Gás Total Gasto</span>
                    <strong class="wa-text-main" style="font-size: 1.1rem;">${{ number_format($metrics['gas_spent_usd'], 2, ',', '.') }}</strong>
                </div>
                <x-heroicon-o-fire style="width: 24px; height: 24px; color: #EF4444;" />
            </div>
        </div>

        <!-- 5. GRAFICO DE EVOLUÇÃO PATRIMONIAL ON-CHAIN INTERATIVO -->
        <div class="wa-chart-section" wire:key="unified-chart-{{ $activeAddr }}-{{ $chartType }}-{{ $currency }}-{{ $positionsFilter }}-{{ $reloadTimestamp }}">
            <div class="wa-chart-header">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span class="wa-pulse-dot"></span>
                    <h3 style="font-size: 0.95rem; font-weight: 700; margin: 0;" class="wa-text-main">
                        Curva de Evolução Patrimonial On-Chain ({{ strtoupper($currency) }})
                    </h3>
                </div>
                <div class="wa-text-sub" style="font-size: 0.75rem;">
                    Resolução: <strong style="color: #38BDF8; text-transform: uppercase;">{{ $chartType }}</strong>
                    @if(!empty($chartResult['is_zerion']))
                        <span style="margin-left: 6px; padding: 2px 6px; background: rgba(56, 189, 248, 0.15); border-radius: 4px; color: #38BDF8; font-weight: 700;">Zerion Live</span>
                    @else
                        <span style="margin-left: 6px; padding: 2px 6px; background: rgba(16, 185, 129, 0.15); border-radius: 4px; color: #10B981; font-weight: 700;">Snapshots Banco</span>
                    @endif
                </div>
            </div>

            <!-- Chart Container with Alpine Component -->
            <div class="wa-chart-container"
                 wire:ignore.self
                 x-data="{
                    chart: null,
                    init() {
                        this.$nextTick(() => this.draw());

                        if (typeof Livewire !== 'undefined') {
                            Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
                                succeed(() => {
                                    this.$nextTick(() => {
                                        const canvas = this.$refs.canvas;
                                        if (canvas && (!this.chart || !window.Chart?.getChart(canvas))) {
                                            this.draw();
                                        }
                                    });
                                });
                            });
                        }
                    },
                    cleanupChart() {
                        if (this.chart) {
                            try { this.chart.destroy(); } catch(e) {}
                            this.chart = null;
                        }
                        const canvas = this.$refs.canvas;
                        if (canvas && typeof window.Chart !== 'undefined') {
                            try {
                                const existing = window.Chart.getChart(canvas);
                                if (existing) existing.destroy();
                            } catch(e) {}
                        }
                    },
                    draw() {
                        const canvas = this.$refs.canvas;
                        if (!canvas) return;

                        if (typeof window.Chart === 'undefined') {
                            const timer = setInterval(() => {
                                if (typeof window.Chart !== 'undefined') {
                                    clearInterval(timer);
                                    this.draw();
                                }
                            }, 50);
                            return;
                        }

                        this.cleanupChart();

                        const labels = @js($chartResult['labels'] ?? []);
                        const values = @js($chartResult['values'] ?? []);
                        const symbol = @js($symbol);
                        const isPositive = @js(($stats['trend'] ?? 'positive') === 'positive');

                        if (!labels.length || !values.length) return;

                        const strokeColor = isPositive ? '#10B981' : '#EF4444';
                        const canvasCtx = canvas.getContext('2d');
                        const gradientBg = canvasCtx.createLinearGradient(0, 0, 0, 350);
                        gradientBg.addColorStop(0, isPositive ? 'rgba(16, 185, 129, 0.35)' : 'rgba(239, 68, 68, 0.35)');
                        gradientBg.addColorStop(1, isPositive ? 'rgba(16, 185, 129, 0.0)' : 'rgba(239, 68, 68, 0.0)');

                        try {
                            this.chart = new window.Chart(canvas, {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Patrimônio (' + symbol + ')',
                                        data: values,
                                        borderColor: strokeColor,
                                        borderWidth: 2.5,
                                        backgroundColor: gradientBg,
                                        fill: true,
                                        tension: 0.25,
                                        pointRadius: values.length > 50 ? 0 : 3,
                                        pointHoverRadius: 6,
                                        pointHoverBackgroundColor: strokeColor,
                                        pointHoverBorderColor: '#FFFFFF',
                                        pointHoverBorderWidth: 2,
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    animation: { duration: 250 },
                                    interaction: {
                                        mode: 'index',
                                        intersect: false,
                                    },
                                    plugins: {
                                        legend: { display: false },
                                        tooltip: {
                                            backgroundColor: '#18191D',
                                            titleColor: '#9CA3AF',
                                            bodyColor: '#F3F4F6',
                                            borderColor: '#2D2F36',
                                            borderWidth: 1,
                                            padding: 12,
                                            displayColors: false,
                                            callbacks: {
                                                label: function(context) {
                                                    const val = context.parsed.y;
                                                    return 'Patrimônio: ' + symbol + ' ' + Number(val).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        x: {
                                            grid: { color: 'rgba(255, 255, 255, 0.07)', drawBorder: false },
                                            ticks: {
                                                color: '#9CA3AF',
                                                maxRotation: 0,
                                                autoSkip: true,
                                                maxTicksLimit: 10,
                                                font: { size: 10 }
                                            }
                                        },
                                        y: {
                                            grid: { color: 'rgba(255, 255, 255, 0.07)', drawBorder: false },
                                            ticks: {
                                                color: '#9CA3AF',
                                                font: { size: 10 },
                                                callback: function(value) {
                                                    return symbol + ' ' + Number(value).toLocaleString('pt-BR', { notation: 'compact', compactDisplay: 'short' });
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        } catch(err) {
                            console.error('Erro ao renderizar Chart.js:', err);
                        }
                    }
                 }"
                 x-init="init()"
                 x-on:zerion-chart-reload.window="draw()"
            >
                <!-- Loading Overlay no Centro Exato do Gráfico -->
                <div
                    wire:loading.flex
                    wire:target="setPeriod, selectedWalletId, clearCacheAndReload, currency, positionsFilter, selectedNetwork"
                    class="wa-loading-overlay"
                >
                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; margin: auto;">
                        <x-heroicon-o-arrow-path class="wa-spin" style="width: 40px; height: 40px; color: #38BDF8;" />
                        <span style="font-size: 0.9rem; font-weight: 600; color: #F8FAFC; letter-spacing: 0.3px;">Sincronizando dados on-chain...</span>
                    </div>
                </div>

                <canvas wire:ignore x-ref="canvas"></canvas>
            </div>
        </div>

        <!-- 6. SEÇÕES DE ATIVOS & INTELIGÊNCIA EM ABAS (TOKENS, DEFI, NFTS, BUY MOMENTUM, TRANSAÇÕES) -->
        <div class="wa-section-card">
            <!-- NAVEGAÇÃO POR ABAS -->
            <div class="wa-tabs-nav">
                <button
                    type="button"
                    wire:click="setActiveTab('tokens')"
                    class="wa-tab-btn {{ $activeTab === 'tokens' ? 'active' : '' }}"
                >
                    <x-heroicon-o-currency-dollar style="width: 18px; height: 18px;" />
                    <span>Tokens da Carteira ({{ $tokens->count() }})</span>
                </button>

                <button
                    type="button"
                    wire:click="setActiveTab('defi')"
                    class="wa-tab-btn {{ $activeTab === 'defi' ? 'active' : '' }}"
                >
                    <x-heroicon-o-building-library style="width: 18px; height: 18px;" />
                    <span>Posições DeFi ({{ $defiPositions->count() }})</span>
                </button>

                <button
                    type="button"
                    wire:click="setActiveTab('nfts')"
                    class="wa-tab-btn {{ $activeTab === 'nfts' ? 'active' : '' }}"
                >
                    <x-heroicon-o-photo style="width: 18px; height: 18px;" />
                    <span>Inventário de NFTs ({{ $nfts->total() }})</span>
                </button>

                <button
                    type="button"
                    wire:click="setActiveTab('top_buys')"
                    class="wa-tab-btn {{ $activeTab === 'top_buys' ? 'active' : '' }}"
                >
                    <x-heroicon-o-arrow-trending-up style="width: 18px; height: 18px;" />
                    <span>Buy Momentum & DCA</span>
                </button>

                <button
                    type="button"
                    wire:click="setActiveTab('transactions')"
                    class="wa-tab-btn {{ $activeTab === 'transactions' ? 'active' : '' }}"
                >
                    <x-heroicon-o-arrows-right-left style="width: 18px; height: 18px;" />
                    <span>Transações ({{ $this->transactionsCount }})</span>
                </button>
            </div>

            <!-- CONTEÚDO DA ABA: TOKENS -->
            @if ($activeTab === 'tokens')
                <div>
                    <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 16px;">
                        <!-- Filtro por Rede -->
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span class="wa-filter-label" style="margin: 0;">Filtrar por Rede:</span>
                            <select wire:model.live="selectedNetwork" class="wa-select-custom" style="width: auto; min-width: 150px; height: 32px; padding: 4px 10px;">
                                <option value="all">🌐 Todas as Redes</option>
                                @foreach($availableNetworks as $net)
                                    <option value="{{ $net }}">{{ ucfirst(str_replace('-', ' ', $net)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="wa-text-sub" style="font-size: 0.75rem;">
                            Total em Tokens: <strong class="wa-text-main" style="font-weight: 700;">${{ number_format((float) ($tokens->sum('balance_usd') ?? 0), 2, ',', '.') }}</strong>
                        </span>
                    </div>

                    <div class="wa-table-scroll">
                        <table class="wa-table">
                            <thead>
                                <tr>
                                    <th>Token</th>
                                    <th>Rede</th>
                                    <th style="text-align: right;">Quantidade</th>
                                    <th style="text-align: right;">Preço Unitário</th>
                                    <th style="text-align: right;">Saldo Total (USD)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tokens as $token)
                                    <tr>
                                        <td>
                                            <div class="wa-token-info">
                                                @if ($token->logo_url)
                                                    <img src="{{ $token->logo_url }}" class="wa-token-icon" alt="{{ $token->symbol }}" onerror="this.style.display='none'" />
                                                @else
                                                    <span class="wa-token-avatar">
                                                        {{ substr($token->symbol, 0, 3) }}
                                                    </span>
                                                @endif
                                                <div>
                                                    <strong class="wa-text-main" style="display: block; font-weight: 700; line-height: 1.1;">{{ $token->symbol }}</strong>
                                                    <span class="wa-text-sub" style="font-size: 0.7rem; display: block; margin-top: 2px;">{{ $token->name ?: $token->symbol }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="wa-badge wa-badge-sky">
                                                {{ strtoupper($token->network) }}
                                            </span>
                                        </td>
                                        <td class="wa-mono-val wa-text-sub" style="text-align: right;">
                                            {{ number_format((float) ($token->balance_quantity ?? 0), 4, ',', '.') }}
                                        </td>
                                        <td class="wa-mono-val wa-text-sub" style="text-align: right;">
                                            ${{ number_format((float) ($token->token_price_usd ?? 0), 4, ',', '.') }}
                                        </td>
                                        <td class="wa-mono-val" style="text-align: right; font-weight: 700; color: #10B981;">
                                            ${{ number_format((float) ($token->balance_usd ?? 0), 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="wa-text-sub" style="text-align: center; padding: 24px;">
                                            Nenhum token encontrado no banco de dados para os filtros selecionados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- CONTEÚDO DA ABA: DEFI -->
            @if ($activeTab === 'defi')
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                        <span class="wa-card-title">Posições em Protocolos DeFi</span>
                        <span class="wa-text-sub" style="font-size: 0.75rem;">Total em DeFi: <strong class="wa-text-main">${{ number_format($metrics['defi_total'], 2, ',', '.') }}</strong></span>
                    </div>

                    <div style="max-height: 380px; overflow-y: auto; padding-right: 4px;">
                        @forelse($defiPositions as $d)
                            <div class="wa-defi-card">
                                <div style="display: flex; align-items: center; gap: 12px;">
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
                                            <span class="wa-badge wa-badge-sky" style="font-size: 0.65rem;">{{ strtoupper($d->position_type) }}</span>
                                            @if($d->apr)
                                                <span style="font-size: 0.7rem; color: #10B981; font-weight: 800;">APR {{ number_format($d->apr, 2) }}%</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <strong class="wa-text-main" style="font-size: 0.9rem; display: block;">$ {{ number_format($d->total_value_usd, 2, ',', '.') }}</strong>
                                    @if($d->rewards_value_usd > 0)
                                        <span style="font-size: 0.7rem; color: #10B981; display: block;">+ ${{ number_format($d->rewards_value_usd, 2, ',', '.') }} Recompensas</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="wa-text-sub" style="padding: 30px; text-align: center; font-size: 0.8rem;">
                                Nenhuma posição DeFi encontrada nas carteiras selecionadas.
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif

            <!-- CONTEÚDO DA ABA: NFTS -->
            @if ($activeTab === 'nfts')
                <div id="nft-section">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                        <span class="wa-card-title">Galeria e Floor Price de Coleções NFT</span>
                        <span class="wa-text-sub" style="font-size: 0.75rem;">Total em NFTs: <strong class="wa-text-main">${{ number_format($metrics['nfts_total'], 2, ',', '.') }}</strong></span>
                    </div>

                    <div class="wa-nft-grid">
                        @forelse($nfts as $nft)
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
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px; padding-top: 8px; border-top: 1px solid #334155;">
                                        <span class="wa-text-sub" style="font-size: 0.65rem;">Floor Price:</span>
                                        <strong style="font-size: 0.85rem; color: #10B981;">$ {{ number_format($nft->estimated_value_usd, 2, ',', '.') }}</strong>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="wa-text-sub" style="grid-column: 1 / -1; text-align: center; padding: 40px; font-size: 0.8rem;">
                                Nenhum NFT cadastrado ou sincronizado no banco.
                            </div>
                        @endforelse
                    </div>

                    @if($nfts->hasPages())
                        <div class="wa-pagination-container">
                            <div class="wa-text-sub" style="font-size: 0.8rem; display: flex; align-items: center; gap: 8px;">
                                <span>Mostrando <strong class="wa-text-main">{{ $nfts->firstItem() ?? 0 }}</strong> a <strong class="wa-text-main">{{ $nfts->lastItem() ?? 0 }}</strong> de <strong class="wa-text-main">{{ $nfts->total() }}</strong> NFTs</span>
                                <span style="padding: 2px 8px; background: #18191D; border: 1px solid #2D2F36; border-radius: 4px; font-size: 0.72rem; color: #9CA3AF; font-weight: 600;">
                                    Página {{ $nfts->currentPage() }} de {{ $nfts->lastPage() }}
                                </span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <button
                                    type="button"
                                    wire:click="previousPage('page')"
                                    class="wa-pagination-btn"
                                    @if($nfts->onFirstPage()) disabled @endif
                                >
                                    <x-heroicon-m-chevron-left style="width: 14px; height: 14px;" />
                                    <span>Anterior</span>
                                </button>
                                <button
                                    type="button"
                                    wire:click="nextPage('page')"
                                    class="wa-pagination-btn"
                                    @if(!$nfts->hasMorePages()) disabled @endif
                                >
                                    <span>Próxima</span>
                                    <x-heroicon-m-chevron-right style="width: 14px; height: 14px;" />
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- CONTEÚDO DA ABA: BUY MOMENTUM & DCA -->
            @if ($activeTab === 'top_buys')
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                        <span class="wa-card-title">Tokens Mais Comprados & Entradas Médias</span>
                        <span class="wa-badge wa-badge-success">Buy Momentum</span>
                    </div>

                    <div class="wa-table-scroll">
                        <table class="wa-table">
                            <thead>
                                <tr>
                                    <th>Ativo</th>
                                    <th>Rede</th>
                                    <th style="text-align: right;">Volume Alocado</th>
                                    <th style="text-align: right;">Preço DCA</th>
                                    <th style="text-align: center;">Frequência de Compras</th>
                                    <th style="text-align: right;">Tendência 24h</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topBoughtTokens as $t)
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
                                            <span class="wa-badge wa-badge-sky">
                                                {{ $t['network'] }}
                                            </span>
                                        </td>
                                        <td class="wa-text-main wa-mono-val" style="text-align: right; font-weight: 700;">
                                            $ {{ number_format($t['allocated_usd'], 2, ',', '.') }}
                                        </td>
                                        <td class="wa-text-sub wa-mono-val" style="text-align: right;">
                                            $ {{ number_format($t['dca_price'], 2, ',', '.') }}
                                        </td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                                                <div class="wa-progress-bar" style="width: 70px; margin: 0;">
                                                    <div class="wa-progress-fill" style="width: {{ $t['buy_ratio'] }}%; background: #10B981;"></div>
                                                </div>
                                                <span style="font-size: 0.7rem; font-weight: 800; color: #10B981;">{{ $t['buy_ratio'] }}%</span>
                                            </div>
                                        </td>
                                        <td class="wa-mono-val" style="text-align: right; font-weight: 800; color: #10B981;">
                                            +{{ number_format($t['price_change_24h'], 2, ',', '.') }}%
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="wa-text-sub" style="text-align: center; padding: 24px;">
                                            Nenhum histórico de compras encontrado.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- CONTEÚDO DA ABA: TRANSAÇÕES -->
            @if ($activeTab === 'transactions')
                <div>
                    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 16px;">
                        <div>
                            <span class="wa-card-title">Auditoria & Movimentações On-Chain</span>
                        </div>

                        <!-- Filtro por Tipo de Ação -->
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <label for="tx-action-type" class="wa-text-sub" style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase;">
                                Operação:
                            </label>
                            <select
                                id="tx-action-type"
                                wire:model.live="selectedActionType"
                                class="wa-select-custom"
                                style="min-width: 180px; padding: 6px 12px; font-size: 0.75rem;"
                            >
                                @foreach ($this->availableActionTypes as $actionKey => $actionLabel)
                                    <option value="{{ $actionKey }}">{{ $actionLabel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="wa-table-scroll">
                        <table class="wa-table">
                            <thead>
                                <tr>
                                    <th>Data / Hora</th>
                                    <th>Operação</th>
                                    <th>Descrição / Deltas</th>
                                    <th style="text-align: right;">Volume (USD)</th>
                                    <th style="text-align: right;">Gás (USD)</th>
                                    <th>Rede</th>
                                    <th style="text-align: center;">Explorer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($this->transactions as $tx)
                                    @php
                                        $actionType = strtolower($tx->action_type ?? 'unknown');
                                        $badgeClass = match($actionType) {
                                            'trade', 'swap' => 'wa-badge-sky',
                                            'receive', 'buy' => 'wa-badge-success',
                                            'send', 'sell' => 'wa-badge-danger',
                                            'deposit' => 'wa-badge-purple',
                                            'withdraw' => 'wa-badge-amber',
                                            'mint' => 'wa-badge-purple',
                                            'burn' => 'wa-badge-danger',
                                            default => 'wa-badge-neutral',
                                        };
                                        $deltas = $tx->asset_deltas ?? [];
                                        $sentList = $deltas['sent'] ?? [];
                                        $rcvList = $deltas['received'] ?? [];
                                    @endphp
                                    <tr>
                                        <!-- Data / Hora -->
                                        <td style="white-space: nowrap;">
                                            <div class="wa-text-main" style="font-weight: 600; font-size: 0.78rem;">
                                                {{ $tx->transaction_at ? $tx->transaction_at->format('d/m/Y H:i') : '-' }}
                                            </div>
                                            <div class="wa-text-sub" style="font-size: 0.65rem;">
                                                {{ $tx->transaction_at ? $tx->transaction_at->diffForHumans() : '' }}
                                            </div>
                                        </td>

                                        <!-- Operação Badge -->
                                        <td>
                                            <span class="wa-badge {{ $badgeClass }}">
                                                {{ strtoupper($tx->action_type) }}
                                            </span>
                                        </td>

                                        <!-- Descrição & Deltas -->
                                        <td>
                                            <div class="wa-text-main" style="font-weight: 600; font-size: 0.78rem; margin-bottom: 4px;">
                                                {{ $tx->friendly_description }}
                                            </div>

                                            @if(!empty($sentList) || !empty($rcvList))
                                                <div style="display: flex; flex-wrap: wrap; gap: 6px; align-items: center;">
                                                    @foreach($sentList as $s)
                                                        <span class="wa-badge wa-badge-danger" style="font-size: 0.65rem; padding: 2px 6px; gap: 4px;">
                                                            @if(!empty($s['icon_url']))
                                                                <img src="{{ $s['icon_url'] }}" style="width: 12px; height: 12px; border-radius: 50%;" alt="{{ $s['symbol'] }}">
                                                            @endif
                                                            - {{ number_format((float) ($s['amount'] ?? 0), 4, ',', '.') }} {{ $s['symbol'] }}
                                                        </span>
                                                    @endforeach

                                                    @if(!empty($sentList) && !empty($rcvList))
                                                        <x-heroicon-m-arrow-right style="width: 12px; height: 12px; color: #94A3B8;" />
                                                    @endif

                                                    @foreach($rcvList as $r)
                                                        <span class="wa-badge wa-badge-success" style="font-size: 0.65rem; padding: 2px 6px; gap: 4px;">
                                                            @if(!empty($r['icon_url']))
                                                                <img src="{{ $r['icon_url'] }}" style="width: 12px; height: 12px; border-radius: 50%;" alt="{{ $r['symbol'] }}">
                                                            @endif
                                                            + {{ number_format((float) ($r['amount'] ?? 0), 4, ',', '.') }} {{ $r['symbol'] }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>

                                        <!-- Volume USD -->
                                        <td class="wa-text-main wa-mono-val" style="text-align: right; font-weight: 700;">
                                            @if($tx->transaction_value_usd)
                                                $ {{ number_format((float) $tx->transaction_value_usd, 2, ',', '.') }}
                                            @else
                                                <span class="wa-text-sub">-</span>
                                            @endif
                                        </td>

                                        <!-- Gás Fee USD -->
                                        <td class="wa-mono-val" style="text-align: right;">
                                            @if($tx->gas_fee_usd)
                                                <span class="wa-text-sub" style="font-size: 0.75rem;">$ {{ number_format((float) $tx->gas_fee_usd, 4, ',', '.') }}</span>
                                            @else
                                                <span class="wa-text-sub">-</span>
                                            @endif
                                        </td>

                                        <!-- Rede -->
                                        <td>
                                            <span class="wa-badge wa-badge-sky">
                                                {{ strtoupper($tx->network) }}
                                            </span>
                                        </td>

                                        <!-- Explorer Link -->
                                        <td style="text-align: center;">
                                            @if($tx->tx_hash)
                                                <a
                                                    href="{{ $tx->explorer_url }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="wa-mono-val"
                                                    style="display: inline-flex; align-items: center; gap: 4px; color: #38BDF8; font-size: 0.72rem; text-decoration: none;"
                                                    title="Abrir no Explorador de Blocos"
                                                >
                                                    <span>{{ $tx->short_hash }}</span>
                                                    <x-heroicon-m-arrow-top-right-on-square style="width: 13px; height: 13px;" />
                                                </a>
                                            @else
                                                <span class="wa-text-sub">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="wa-text-sub" style="text-align: center; padding: 28px;">
                                            Nenhuma transação encontrada para os filtros selecionados. Sincronize a carteira para atualizar o histórico on-chain.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- PAGINAÇÃO DE TRANSAÇÕES -->
                    @if ($this->transactions->hasPages())
                        <div class="wa-pagination-container">
                            <div class="wa-text-sub" style="font-size: 0.8rem; display: flex; align-items: center; gap: 8px;">
                                <span>Mostrando <strong class="wa-text-main">{{ $this->transactions->firstItem() ?? 0 }}</strong> a <strong class="wa-text-main">{{ $this->transactions->lastItem() ?? 0 }}</strong> de <strong class="wa-text-main">{{ $this->transactions->total() }}</strong> transações</span>
                                <span style="padding: 2px 8px; background: #18191D; border: 1px solid #2D2F36; border-radius: 4px; font-size: 0.72rem; color: #9CA3AF; font-weight: 600;">
                                    Página {{ $this->transactions->currentPage() }} de {{ $this->transactions->lastPage() }}
                                </span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <button
                                    type="button"
                                    wire:click="previousPage('txPage')"
                                    class="wa-pagination-btn"
                                    @if($this->transactions->onFirstPage()) disabled @endif
                                >
                                    <x-heroicon-m-chevron-left style="width: 14px; height: 14px;" />
                                    <span>Anterior</span>
                                </button>
                                <button
                                    type="button"
                                    wire:click="nextPage('txPage')"
                                    class="wa-pagination-btn"
                                    @if(!$this->transactions->hasMorePages()) disabled @endif
                                >
                                    <span>Próxima</span>
                                    <x-heroicon-m-chevron-right style="width: 14px; height: 14px;" />
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>

    </div>
</x-filament-panels::page>