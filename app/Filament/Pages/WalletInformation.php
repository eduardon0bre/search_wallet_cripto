<?php

namespace App\Filament\Pages;

use App\Models\Models\WalletsWeb3\Wallet;
use App\Models\Models\WalletsWeb3\WalletSnapshot;
use App\Services\ZerionService;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use UnitEnum;

class WalletInformation extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

    protected static string|UnitEnum|null $navigationGroup = 'Carteiras Web3';

    protected static ?string $navigationLabel = 'Informações';

    protected static ?string $title = 'Informações On-Chain & Amostras da API';

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.pages.wallet-information';

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    public string $selectedWalletId = '';

    public string $chartType = 'month'; // 'hour', 'day', 'week', 'month', 'year', 'max'

    public string $currency = 'usd';    // 'usd', 'brl', 'eur', 'btc', 'eth'

    public string $positionsFilter = 'no_filter'; // 'no_filter', 'only_simple', 'only_complex'

    public string $samplesLimit = '10'; // '10', '25', '50', '100', 'all'

    public string $sortOrder = 'desc';  // 'desc' (mais recentes), 'asc' (mais antigos)

    public ?string $errorMessage = null;

    public function mount(): void
    {
        $firstWallet = Wallet::orderBy('label')->first();
        if ($firstWallet) {
            $this->selectedWalletId = (string) $firstWallet->id;
        } else {
            $this->selectedWalletId = 'all';
        }
    }

    public function updatedSelectedWalletId(): void
    {
        $this->errorMessage = null;
    }

    public function updatedChartType(): void
    {
        $this->errorMessage = null;
    }

    public function updatedCurrency(): void
    {
        $this->errorMessage = null;
    }

    public function updatedPositionsFilter(): void
    {
        $this->errorMessage = null;
    }

    public function updatedSamplesLimit(): void
    {
        $this->errorMessage = null;
    }

    public function updatedSortOrder(): void
    {
        $this->errorMessage = null;
    }

    public function clearCacheAndReload(): void
    {
        $address = $this->getActiveAddress();
        if ($address) {
            $periods = ['hour', 'day', 'week', 'month', 'year', 'max'];
            $currencies = ['usd', 'brl', 'eur', 'btc', 'eth'];
            $positions = ['no_filter', 'only_simple', 'only_complex'];

            foreach ($periods as $p) {
                foreach ($currencies as $c) {
                    foreach ($positions as $pos) {
                        Cache::forget('zerion_chart_v2_'.md5(strtolower($address)."_{$p}_{$c}_{$pos}"));
                    }
                }
            }
        }
        $this->errorMessage = null;
    }

    #[Computed]
    public function wallets(): Collection
    {
        return Wallet::orderBy('label')->get();
    }

    #[Computed]
    public function currentWallet(): ?Wallet
    {
        if ($this->selectedWalletId === 'all' || empty($this->selectedWalletId)) {
            return null;
        }

        return Wallet::find($this->selectedWalletId);
    }

    public function getActiveAddress(): ?string
    {
        if ($this->selectedWalletId === 'all' || empty($this->selectedWalletId)) {
            return null;
        }

        $wallet = Wallet::find($this->selectedWalletId);

        return $wallet ? trim($wallet->wallet_address) : null;
    }

    #[Computed]
    public function currencySymbol(): string
    {
        return match (strtolower($this->currency)) {
            'brl' => 'R$',
            'eur' => '€',
            'btc' => '₿',
            'eth' => 'Ξ',
            default => '$',
        };
    }

    #[Computed]
    public function lastSyncLogs(): Collection
    {
        $query = DB::table('zerion_sync_logs');

        if ($this->selectedWalletId !== 'all' && ! empty($this->selectedWalletId)) {
            $query->where('wallet_id', $this->selectedWalletId);
        }

        return $query->orderByDesc('created_at')->limit(5)->get();
    }

    #[Computed]
    public function apiData(): array
    {
        $address = $this->getActiveAddress();

        if ($address) {
            $cacheKey = 'zerion_chart_v2_'.md5(strtolower($address)."_{$this->chartType}_{$this->currency}_{$this->positionsFilter}");
            $ttlSeconds = match ($this->chartType) {
                'hour' => 600,
                'day' => 1800,
                'week' => 3600,
                'month' => 7200,
                'year' => 21600,
                'max' => 43200,
                default => 3600,
            };

            try {
                $rawApi = Cache::remember($cacheKey, $ttlSeconds, function () use ($address) {
                    /** @var ZerionService $zerionService */
                    $zerionService = app(ZerionService::class);

                    return $zerionService->getWalletChart(
                        walletAddress: $address,
                        chartType: $this->chartType,
                        currency: $this->currency,
                        positionsFilter: $this->positionsFilter
                    );
                });

                $attributes = $rawApi['data']['attributes'] ?? [];
                $rawPoints = $attributes['points'] ?? [];

                if (empty($rawPoints)) {
                    return [
                        'has_data' => false,
                        'is_zerion' => true,
                        'error' => 'Nenhum ponto histórico retornado pela Zerion API.',
                        'points' => [],
                        'stats' => [],
                        'raw_attributes' => $attributes,
                    ];
                }

                $points = [];
                $prevVal = null;

                foreach ($rawPoints as $index => $pt) {
                    $ts = $pt[0] ?? null;
                    $val = (float) ($pt[1] ?? 0);
                    if ($ts === null) {
                        continue;
                    }

                    $carbon = Carbon::createFromTimestampUTC($ts)->setTimezone('America/Sao_Paulo');
                    $delta = $prevVal !== null ? ($val - $prevVal) : 0.0;
                    $deltaPercent = ($prevVal !== null && $prevVal > 0) ? (($delta / $prevVal) * 100) : 0.0;

                    $points[] = [
                        'index' => $index + 1,
                        'timestamp' => $ts,
                        'formatted_date' => $carbon->format('d/m/Y H:i:s'),
                        'time_ago' => $carbon->diffForHumans(),
                        'value' => $val,
                        'delta' => $delta,
                        'delta_percent' => $deltaPercent,
                    ];

                    $prevVal = $val;
                }

                $values = array_column($points, 'value');
                $startVal = reset($values);
                $endVal = end($values);
                $change = $endVal - $startVal;
                $changePct = $startVal > 0 ? (($change / $startVal) * 100) : 0;

                $stats = [
                    'total_points' => count($points),
                    'begin_at' => isset($attributes['begin_at']) ? Carbon::parse($attributes['begin_at'])->format('d/m/Y H:i:s') : ($points[0]['formatted_date'] ?? null),
                    'end_at' => isset($attributes['end_at']) ? Carbon::parse($attributes['end_at'])->format('d/m/Y H:i:s') : (end($points)['formatted_date'] ?? null),
                    'start_value' => $startVal,
                    'current_value' => $endVal,
                    'change_value' => $change,
                    'change_percent' => $changePct,
                    'min_value' => min($values),
                    'max_value' => max($values),
                    'avg_value' => count($values) > 0 ? (array_sum($values) / count($values)) : 0,
                ];

                if ($this->sortOrder === 'desc') {
                    $points = array_reverse($points);
                }

                $limitedPoints = match ($this->samplesLimit) {
                    '10' => array_slice($points, 0, 10),
                    '25' => array_slice($points, 0, 25),
                    '50' => array_slice($points, 0, 50),
                    '100' => array_slice($points, 0, 100),
                    default => $points,
                };

                return [
                    'has_data' => true,
                    'is_zerion' => true,
                    'error' => null,
                    'points' => $limitedPoints,
                    'stats' => $stats,
                    'raw_attributes' => $attributes,
                ];
            } catch (\Throwable $e) {
                return [
                    'has_data' => false,
                    'is_zerion' => true,
                    'error' => 'Falha ao consultar Zerion API: '.$e->getMessage(),
                    'points' => [],
                    'stats' => [],
                    'raw_attributes' => [],
                ];
            }
        }

        // Modo Consolidado (Todas as Carteiras)
        $snapshots = WalletSnapshot::orderBy('snapshot_at')->get();
        if ($snapshots->isEmpty()) {
            return [
                'has_data' => false,
                'is_zerion' => false,
                'error' => 'Nenhum snapshot patrimonial encontrado para consolidação.',
                'points' => [],
                'stats' => [],
                'raw_attributes' => [],
            ];
        }

        $points = [];
        $prevVal = null;
        foreach ($snapshots as $idx => $s) {
            $val = (float) $s->total_net_worth_usd;
            $delta = $prevVal !== null ? ($val - $prevVal) : 0.0;
            $deltaPercent = ($prevVal !== null && $prevVal > 0) ? (($delta / $prevVal) * 100) : 0.0;

            $points[] = [
                'index' => $idx + 1,
                'timestamp' => $s->snapshot_at->timestamp,
                'formatted_date' => $s->snapshot_at->format('d/m/Y H:i:s'),
                'time_ago' => $s->snapshot_at->diffForHumans(),
                'value' => $val,
                'delta' => $delta,
                'delta_percent' => $deltaPercent,
            ];
            $prevVal = $val;
        }

        $values = array_column($points, 'value');
        $startVal = reset($values);
        $endVal = end($values);
        $change = $endVal - $startVal;
        $changePct = $startVal > 0 ? (($change / $startVal) * 100) : 0;

        $stats = [
            'total_points' => count($points),
            'begin_at' => $points[0]['formatted_date'] ?? null,
            'end_at' => end($points)['formatted_date'] ?? null,
            'start_value' => $startVal,
            'current_value' => $endVal,
            'change_value' => $change,
            'change_percent' => $changePct,
            'min_value' => min($values),
            'max_value' => max($values),
            'avg_value' => count($values) > 0 ? (array_sum($values) / count($values)) : 0,
        ];

        if ($this->sortOrder === 'desc') {
            $points = array_reverse($points);
        }

        $limitedPoints = match ($this->samplesLimit) {
            '10' => array_slice($points, 0, 10),
            '25' => array_slice($points, 0, 25),
            '50' => array_slice($points, 0, 50),
            '100' => array_slice($points, 0, 100),
            default => $points,
        };

        return [
            'has_data' => true,
            'is_zerion' => false,
            'error' => null,
            'points' => $limitedPoints,
            'stats' => $stats,
            'raw_attributes' => ['consolidated' => true],
        ];
    }
}
