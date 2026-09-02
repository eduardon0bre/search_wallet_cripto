<x-filament-panels::page>
    @push('styles')
        <style>
            .wi-dashboard {
                background-color: #16171A !important;
                color: #F3F4F6 !important;
                font-family: 'Inter', system-ui, -apple-system, sans-serif;
                border-radius: 12px;
                padding: 24px;
                margin-top: -10px;
                border: 1px solid #26272B;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
            }

            .wi-header {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                padding-bottom: 20px;
                border-bottom: 1px solid #2D2F36;
                margin-bottom: 24px;
            }

            .wi-title-group h2 {
                font-size: 1.5rem;
                font-weight: 800;
                color: #F3F4F6;
                margin: 0;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .wi-title-sub {
                font-size: 0.8rem;
                color: #9CA3AF;
                margin-top: 4px;
            }

            .wi-text-main {
                color: #F3F4F6;
            }

            .wi-text-sub {
                color: #9CA3AF;
            }

            .wi-badge {
                display: inline-flex;
                align-items: center;
                padding: 3px 8px;
                border-radius: 4px;
                font-weight: 700;
                font-size: 0.7rem;
                letter-spacing: 0.5px;
                text-transform: uppercase;
            }

            .wi-badge-sky {
                background-color: rgba(56, 189, 248, 0.12);
                color: #38BDF8;
                border: 1px solid rgba(56, 189, 248, 0.3);
            }

            .wi-badge-success {
                background-color: rgba(16, 185, 129, 0.15);
                color: #10B981;
                border: 1px solid rgba(16, 185, 129, 0.35);
            }

            .wi-badge-danger {
                background-color: rgba(239, 68, 68, 0.15);
                color: #EF4444;
                border: 1px solid rgba(239, 68, 68, 0.35);
            }

            .wi-badge-amber {
                background-color: rgba(245, 158, 11, 0.15);
                color: #FBBF24;
                border: 1px solid rgba(245, 158, 11, 0.35);
            }

            .wi-badge-neutral {
                background-color: rgba(161, 161, 170, 0.15);
                color: #9CA3AF;
                border: 1px solid rgba(161, 161, 170, 0.3);
            }

            /* BARRA DE FILTROS */
            .wi-filter-card {
                background-color: #202125;
                border: 1px solid #2D2F36;
                border-radius: 12px;
                padding: 20px;
                margin-bottom: 24px;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
            }

            .wi-filter-grid {
                display: grid;
                grid-template-columns: 2fr 1.2fr 1fr 1.2fr 1fr 1fr auto;
                gap: 14px;
                align-items: flex-end;
            }

            @media (max-width: 1400px) {
                .wi-filter-grid {
                    grid-template-columns: 1fr 1fr 1fr;
                }
            }

            @media (max-width: 768px) {
                .wi-filter-grid {
                    grid-template-columns: 1fr;
                }
            }

            .wi-filter-item {
                display: flex;
                flex-direction: column;
                gap: 6px;
            }

            .wi-filter-label {
                font-size: 0.68rem;
                font-weight: 700;
                color: #9CA3AF;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                display: flex;
                align-items: center;
                gap: 6px;
            }

            .wi-select-custom {
                background-color: #18191D !important;
                border: 1px solid #2D2F36 !important;
                color: #F3F4F6 !important;
                border-radius: 8px;
                padding: 8px 12px;
                font-size: 0.8rem;
                font-weight: 600;
                outline: none;
                transition: border-color 0.2s;
                width: 100%;
                height: 38px;
            }

            .wi-select-custom:focus {
                border-color: #38BDF8 !important;
                box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.25) !important;
            }

            .wi-btn-refresh {
                background: linear-gradient(135deg, #0284C7 0%, #0369A1 100%);
                color: #FFFFFF;
                border: 1px solid #38BDF8;
                border-radius: 8px;
                padding: 8px 16px;
                font-size: 0.8rem;
                font-weight: 700;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                transition: all 0.2s;
                white-space: nowrap;
                height: 38px;
                box-shadow: 0 2px 8px rgba(2, 132, 199, 0.3);
            }

            .wi-btn-refresh:hover {
                background: linear-gradient(135deg, #0369A1 0%, #075985 100%);
            }

            /* CARDS & SEÇÕES */
            .wi-section-card {
                background-color: #202125;
                border: 1px solid #2D2F36;
                border-radius: 12px;
                padding: 22px;
                margin-bottom: 24px;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
            }

            .wi-card-title {
                font-size: 0.95rem;
                font-weight: 800;
                color: #F3F4F6;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            /* GRID DE CARDS DE KPI */
            .wi-kpi-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 16px;
                margin-bottom: 24px;
            }

            .wi-kpi-card {
                background-color: #18191D;
                border: 1px solid #2D2F36;
                border-radius: 10px;
                padding: 16px;
                display: flex;
                flex-direction: column;
                gap: 6px;
            }

            .wi-kpi-label {
                font-size: 0.7rem;
                font-weight: 700;
                color: #9CA3AF;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .wi-kpi-val {
                font-size: 1.25rem;
                font-weight: 800;
                color: #F3F4F6;
                font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            }

            .wi-kpi-sub {
                font-size: 0.7rem;
                color: #6B7280;
            }

            /* TABELA */
            .wi-table-scroll {
                overflow-x: auto;
                border-radius: 8px;
                border: 1px solid #2D2F36;
            }

            .wi-table {
                width: 100%;
                border-collapse: collapse;
                text-align: left;
                font-size: 0.8rem;
            }

            .wi-table th {
                background-color: #18191D;
                color: #9CA3AF;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                font-size: 0.7rem;
                padding: 12px 16px;
                border-bottom: 1px solid #2D2F36;
            }

            .wi-table td {
                padding: 12px 16px;
                border-bottom: 1px solid #2D2F36;
                background-color: #202125;
                color: #F3F4F6;
            }

            .wi-table tr:hover td {
                background-color: #282A30;
            }

            .wi-mono-val {
                font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
                font-variant-numeric: tabular-nums;
            }

            .wi-spin {
                animation: wiSpin 1s linear infinite;
            }

            @keyframes wiSpin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            /* DARK MODE HARMONIZATION */
            html.dark .wi-dashboard {
                background-color: #16171A !important;
                color: #F3F4F6 !important;
                border-color: #26272B !important;
            }

            html.dark .wi-header {
                border-bottom-color: #2D2F36;
            }

            html.dark .wi-title-group h2 {
                color: #F3F4F6;
            }

            html.dark .wi-filter-card,
            html.dark .wi-section-card {
                background-color: #202125;
                border-color: #2D2F36;
            }

            html.dark .wi-kpi-card {
                background-color: #18191D;
                border-color: #2D2F36;
            }

            html.dark .wi-select-custom {
                background-color: #18191D !important;
                color: #F3F4F6 !important;
                border-color: #2D2F36 !important;
            }

            html.dark .wi-table th {
                background-color: #18191D !important;
                color: #9CA3AF !important;
                border-color: #2D2F36 !important;
            }

            html.dark .wi-table td {
                background-color: #202125 !important;
                border-bottom-color: #2D2F36;
                color: #F3F4F6;
            }

            html.dark .wi-table tr:hover td {
                background-color: #282A30 !important;
            }
        </style>
    @endpush

    <div class="wi-dashboard">
        <!-- BARRA DE FILTROS -->
        <div class="wi-filter-card">
            <div class="wi-filter-grid">
                <!-- Seletor de Carteira -->
                <div class="wi-filter-item">
                    <label class="wi-filter-label" for="wi-wallet-select">
                        <x-heroicon-o-wallet style="width: 14px; height: 14px; color: #38BDF8;" />
                        Carteira Ativa
                    </label>
                    <select
                        id="wi-wallet-select"
                        wire:model.live="selectedWalletId"
                        class="wi-select-custom"
                    >
                        <option value="all">Todas as Carteiras (Consolidado Local)</option>
                        @foreach ($this->wallets as $w)
                            <option value="{{ $w->id }}">
                                {{ $w->label ?? 'Sem Nome' }} ({{ substr($w->wallet_address, 0, 6) }}...{{ substr($w->wallet_address, -4) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Período -->
                <div class="wi-filter-item">
                    <label class="wi-filter-label" for="wi-chart-type">
                        <x-heroicon-o-calendar-days style="width: 14px; height: 14px; color: #38BDF8;" />
                        Período da API
                    </label>
                    <select
                        id="wi-chart-type"
                        wire:model.live="chartType"
                        class="wi-select-custom"
                    >
                        <option value="hour">1 Hora (1H)</option>
                        <option value="day">24 Horas (24H)</option>
                        <option value="week">7 Dias (7D)</option>
                        <option value="month">1 Mês (1M)</option>
                        <option value="year">1 Ano (1A)</option>
                        <option value="max">Histórico Total (ALL)</option>
                    </select>
                </div>

                <!-- Moeda -->
                <div class="wi-filter-item">
                    <label class="wi-filter-label" for="wi-currency">
                        <x-heroicon-o-currency-dollar style="width: 14px; height: 14px; color: #38BDF8;" />
                        Moeda
                    </label>
                    <select
                        id="wi-currency"
                        wire:model.live="currency"
                        class="wi-select-custom"
                    >
                        <option value="usd">USD ($)</option>
                        <option value="brl">BRL (R$)</option>
                        <option value="eur">EUR (€)</option>
                        <option value="btc">BTC (₿)</option>
                        <option value="eth">ETH (Ξ)</option>
                    </select>
                </div>

                <!-- Filtro de Ativos -->
                <div class="wi-filter-item">
                    <label class="wi-filter-label" for="wi-positions">
                        <x-heroicon-o-rectangle-stack style="width: 14px; height: 14px; color: #38BDF8;" />
                        Escopo
                    </label>
                    <select
                        id="wi-positions"
                        wire:model.live="positionsFilter"
                        class="wi-select-custom"
                    >
                        <option value="no_filter">Todos os Ativos</option>
                        <option value="only_simple">Apenas Tokens Simples</option>
                        <option value="only_complex">Apenas Posições DeFi</option>
                    </select>
                </div>

                <!-- Quantidade de Amostras -->
                <div class="wi-filter-item">
                    <label class="wi-filter-label" for="wi-limit">
                        <x-heroicon-o-list-bullet style="width: 14px; height: 14px; color: #38BDF8;" />
                        Amostras
                    </label>
                    <select
                        id="wi-limit"
                        wire:model.live="samplesLimit"
                        class="wi-select-custom"
                    >
                        <option value="10">Últimos 10 registros</option>
                        <option value="25">25 registros</option>
                        <option value="50">50 registros</option>
                        <option value="100">100 registros</option>
                        <option value="all">Todos os pontos</option>
                    </select>
                </div>

                <!-- Ordem -->
                <div class="wi-filter-item">
                    <label class="wi-filter-label" for="wi-order">
                        <x-heroicon-o-arrows-up-down style="width: 14px; height: 14px; color: #38BDF8;" />
                        Ordem
                    </label>
                    <select
                        id="wi-order"
                        wire:model.live="sortOrder"
                        class="wi-select-custom"
                    >
                        <option value="desc">Mais recentes primeiro</option>
                        <option value="asc">Mais antigos primeiro</option>
                    </select>
                </div>

                <!-- Botão Recarregar -->
                <div class="wi-filter-item">
                    <button
                        type="button"
                        wire:click="clearCacheAndReload"
                        class="wi-btn-refresh"
                        title="Limpa o cache Laravel e consulta a Zerion API novamente"
                    >
                        <x-heroicon-o-arrow-path wire:loading.class="wi-spin" wire:target="clearCacheAndReload" style="width: 16px; height: 16px;" />
                        <span>Recarregar</span>
                    </button>
                </div>
            </div>
        </div>

        @php
            $apiResult = $this->apiData;
            $stats = $apiResult['stats'] ?? [];
            $points = $apiResult['points'] ?? [];
            $symbol = $this->currencySymbol;
        @endphp

        <!-- SEÇÃO 2: TABELA DO EXPLORADOR DE AMOSTRAS DE PONTOS DA API -->
        <div class="wi-section-card">
            <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 18px;">
                <div class="wi-card-title">
                    <x-heroicon-o-table-cells style="width: 22px; height: 22px; color: #38BDF8;" />
                    <span>Amostras de Pontos da API</span>
                </div>

              
            </div>

            @if (!empty($apiResult['error']))
                <div style="background-color: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 8px; padding: 16px; color: #EF4444; font-size: 0.85rem; margin-bottom: 16px;">
                    {{ $apiResult['error'] }}
                </div>
            @endif

            <div class="wi-table-scroll">
                <table class="wi-table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Data & Horário Formatados</th>
                            <th>Tempo Relativo</th>
                            <th>Timestamp Unix</th>
                            <th style="text-align: right;">Patrimônio On-Chain ({{ $symbol }})</th>
                            <th style="text-align: right;">Variação vs. Ponto Anterior</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($points as $pt)
                            <tr>
                                <td class="wi-text-sub wi-mono-val" style="font-size: 0.72rem;">
                                    #{{ $pt['index'] }}
                                </td>
                                <td class="wi-mono-val" style="font-weight: 600;">
                                    {{ $pt['formatted_date'] }}
                                </td>
                                <td class="wi-text-sub" style="font-size: 0.72rem;">
                                    {{ $pt['time_ago'] }}
                                </td>
                                <td class="wi-text-sub wi-mono-val" style="font-size: 0.72rem;">
                                    {{ $pt['timestamp'] }}
                                </td>
                                <td class="wi-mono-val" style="text-align: right; font-weight: 700; color: #38BDF8;">
                                    {{ $symbol }} {{ number_format((float) ($pt['value'] ?? 0), 2, ',', '.') }}
                                </td>
                                <td class="wi-mono-val" style="text-align: right; font-weight: 600;">
                                    @if (($pt['delta'] ?? 0) > 0)
                                        <span style="color: #10B981;">
                                            +{{ $symbol }} {{ number_format((float) $pt['delta'], 2, ',', '.') }}
                                            <small style="font-size: 0.65rem;">(+{{ number_format((float) $pt['delta_percent'], 2, ',', '.') }}%)</small>
                                        </span>
                                    @elseif (($pt['delta'] ?? 0) < 0)
                                        <span style="color: #EF4444;">
                                            {{ $symbol }} {{ number_format((float) $pt['delta'], 2, ',', '.') }}
                                            <small style="font-size: 0.65rem;">({{ number_format((float) $pt['delta_percent'], 2, ',', '.') }}%)</small>
                                        </span>
                                    @else
                                        <span class="wi-text-sub">0,00</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="wi-text-sub" style="text-align: center; padding: 28px;">
                                    Nenhuma amostra de pontos encontrada para os parâmetros informados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SEÇÃO 3: AUDITORIA E LOGS DE INTEGRAÇÃO COM A ZERION API -->
        <div class="wi-section-card">
            <div class="wi-card-title" style="margin-bottom: 14px;">
                <x-heroicon-o-shield-check style="width: 22px; height: 22px; color: #10B981;" />
                <span>Últimos Logs de Auditoria da API (zerion_sync_logs)</span>
            </div>

            <div class="wi-table-scroll">
                <table class="wi-table">
                    <thead>
                        <tr>
                            <th>Data / Hora</th>
                            <th>Endpoint Consultado</th>
                            <th>Status</th>
                            <th style="text-align: right;">Tempo de Resposta</th>
                            <th style="text-align: right;">Créditos Zerion</th>
                            <th>Mensagem de Erro</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->lastSyncLogs as $log)
                            <tr>
                                <td class="wi-mono-val" style="font-size: 0.75rem;">
                                    {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i:s') }}
                                </td>
                                <td class="wi-mono-val" style="color: #38BDF8; font-size: 0.75rem;">
                                    {{ $log->endpoint }}
                                </td>
                                <td>
                                    @if ($log->status === 'success')
                                        <span class="wi-badge wi-badge-success">SUCESSO</span>
                                    @else
                                        <span class="wi-badge wi-badge-danger">ERRO</span>
                                    @endif
                                </td>
                                <td class="wi-mono-val" style="text-align: right; font-size: 0.75rem;">
                                    {{ $log->response_time_ms ? $log->response_time_ms . ' ms' : '-' }}
                                </td>
                                <td class="wi-mono-val" style="text-align: right; font-size: 0.75rem;">
                                    {{ $log->credits_used ?? 1 }}
                                </td>
                                <td class="wi-text-sub" style="font-size: 0.72rem;">
                                    {{ $log->error_message ?? 'Nenhum erro reportado' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="wi-text-sub" style="text-align: center; padding: 20px;">
                                    Nenhum log de requisição registrado recentemente.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SEÇÃO 4: INSPETOR DE METADADOS BRUTOS DA API (COLAPSÁVEL) -->
        @if (!empty($apiResult['raw_attributes']))
            <div class="wi-section-card" x-data="{ openRaw: false }">
                <div style="display: flex; align-items: center; justify-content: space-between; cursor: pointer;" @click="openRaw = !openRaw">
                    <div class="wi-card-title">
                        <x-heroicon-o-code-bracket style="width: 20px; height: 20px; color: #F59E0B;" />
                        <span>Inspecionador de Resposta Bruta da Zerion API (JSON Payload)</span>
                    </div>
                    <button type="button" style="background: transparent; border: none; font-size: 0.75rem; font-weight: 600; color: #94A3B8; cursor: pointer;">
                        <span x-text="openRaw ? '▲ Ocultar JSON' : '▼ Visualizar JSON'"></span>
                    </button>
                </div>

                <div x-show="openRaw" x-cloak style="margin-top: 14px;">
                    <pre style="background-color: #18191D; border: 1px solid #2D2F36; border-radius: 8px; padding: 16px; color: #38BDF8; font-size: 0.72rem; overflow-x: auto; max-height: 400px; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;">{{ json_encode($apiResult['raw_attributes'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</pre>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
