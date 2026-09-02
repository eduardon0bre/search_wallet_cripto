<?php

namespace App\Services;

use App\Models\Models\WalletsWeb3\Wallet;
use App\Models\Models\WalletsWeb3\WalletDefiPosition;
use App\Models\Models\WalletsWeb3\WalletNft;
use App\Models\Models\WalletsWeb3\WalletSnapshot;
use App\Models\Models\WalletsWeb3\WalletTokenBalance;
use App\Models\Models\WalletsWeb3\WalletTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WalletSyncService
{
    public function __construct(
        protected ZerionService $zerionService
    ) {}

    public function syncWallet(Wallet $wallet): array
    {
        $startTime = microtime(true);
        $syncResults = [
            'tokens_count' => 0,
            'defi_count' => 0,
            'nfts_count' => 0,
            'transactions_count' => 0,
            'status' => 'success',
            'errors' => [],
        ];

        $address = trim($wallet->wallet_address ?? '');

        // Validação de formato EVM (0x + 40 hex chars) ou ENS (.eth)
        if (! preg_match('/^(0x[a-fA-F0-9]{40}|[a-zA-Z0-9-]+\.eth)$/i', $address)) {
            $errorMsg = "Endereço da carteira é inválido: '{$address}'. O formato deve ser um endereço EVM válido (ex: 0x...) ou ENS (.eth).";
            $syncResults['errors'][] = $errorMsg;
            $syncResults['status'] = 'error';
            $this->logSync($wallet->id, 'validateAddress', 'error', $errorMsg, $startTime);
            Log::warning("Tentativa de sincronizar carteira {$wallet->id} com endereço inválido: {$address}");

            return $syncResults;
        }

        // 1. Sincronizar Tokens
        try {
            $tokenData = $this->zerionService->getTokens($wallet->wallet_address);
            $syncResults['tokens_count'] = $this->saveTokenBalances($wallet, $tokenData);
            $this->logSync($wallet->id, 'getTokens', 'success', null, $startTime);
        } catch (\Throwable $e) {
            $syncResults['errors'][] = 'Tokens: '.$e->getMessage();
            $this->logSync($wallet->id, 'getTokens', 'error', $e->getMessage(), $startTime);
            Log::error("Erro ao sincronizar tokens da carteira {$wallet->id}: ".$e->getMessage());
        }

        // 2. Sincronizar Posições DeFi
        try {
            $appData = $this->zerionService->getAppBalances($wallet->wallet_address);
            $syncResults['defi_count'] = $this->saveDefiPositions($wallet, $appData);
            $this->logSync($wallet->id, 'getAppBalances', 'success', null, $startTime);
        } catch (\Throwable $e) {
            $syncResults['errors'][] = 'DeFi: '.$e->getMessage();
            $this->logSync($wallet->id, 'getAppBalances', 'error', $e->getMessage(), $startTime);
            Log::error("Erro ao sincronizar DeFi da carteira {$wallet->id}: ".$e->getMessage());
        }

        usleep(100000);

        // 3. Sincronizar NFTs
        try {
            $nftData = $this->zerionService->getNfts($wallet->wallet_address);
            $syncResults['nfts_count'] = $this->saveNfts($wallet, $nftData);
            $this->logSync($wallet->id, 'getNfts', 'success', null, $startTime);
        } catch (\Throwable $e) {
            $syncResults['errors'][] = 'NFTs: '.$e->getMessage();
            $this->logSync($wallet->id, 'getNfts', 'error', $e->getMessage(), $startTime);
            Log::error("Erro ao sincronizar NFTs da carteira {$wallet->id}: ".$e->getMessage());
        }

        // 4. Sincronizar Transações Decodificadas
        try {
            $txData = $this->zerionService->getTransactions($wallet->wallet_address, 50);
            $syncResults['transactions_count'] = $this->saveTransactions($wallet, $txData);
            $this->logSync($wallet->id, 'getTransactions', 'success', null, $startTime);
        } catch (\Throwable $e) {
            $syncResults['errors'][] = 'Transações: '.$e->getMessage();
            $this->logSync($wallet->id, 'getTransactions', 'error', $e->getMessage(), $startTime);
            Log::error("Erro ao sincronizar transações da carteira {$wallet->id}: ".$e->getMessage());
        }

        if (! empty($syncResults['errors']) && $syncResults['tokens_count'] === 0 && $syncResults['defi_count'] === 0 && $syncResults['nfts_count'] === 0 && $syncResults['transactions_count'] === 0) {
            $syncResults['status'] = 'error';
        } else {
            $wallet->markAsSynced();
            $this->createSnapshotAfterSync($wallet);
        }

        return $syncResults;
    }

    /**
     * Processa e salva saldos de tokens na tabela `wallet_token_balances`
     */
    public function saveTokenBalances(Wallet $wallet, array $apiResponse): int
    {
        $items = $apiResponse['data'] ?? [];
        $count = 0;

        foreach ($items as $item) {
            $attributes = $item['attributes'] ?? null;
            if (! $attributes) {
                continue;
            }

            $fungibleInfo = $attributes['fungible_info'] ?? [];
            $chainData = $item['relationships']['chain']['data'] ?? [];
            $network = $chainData['id'] ?? 'ethereum';

            $implementations = $fungibleInfo['implementations'] ?? [];
            $firstImpl = $implementations[0] ?? [];
            $tokenAddress = $firstImpl['address'] ?? '0x0000000000000000000000000000000000000000';

            WalletTokenBalance::updateOrCreate(
                [
                    'wallet_id' => $wallet->id,
                    'network' => $network,
                    'token_address' => $tokenAddress,
                ],
                [
                    'symbol' => $fungibleInfo['symbol'] ?? 'UNKNOWN',
                    'name' => $fungibleInfo['name'] ?? $attributes['name'] ?? null,
                    'logo_url' => $fungibleInfo['icon']['url'] ?? null,
                    'decimals' => $firstImpl['decimals'] ?? $attributes['quantity']['decimals'] ?? 18,
                    'balance_quantity' => $attributes['quantity']['float'] ?? 0,
                    'balance_usd' => $attributes['value'] ?? 0,
                    'token_price_usd' => $attributes['price'] ?? null,
                    'synced_at' => now(),
                ]
            );

            $count++;
        }

        return $count;
    }

    /**
     * Processa e salva posições DeFi na tabela `wallet_defi_positions`
     */
    public function saveDefiPositions(Wallet $wallet, array $apiResponse): int
    {
        $items = $apiResponse['data'] ?? [];
        $count = 0;

        foreach ($items as $item) {
            $attributes = $item['attributes'] ?? null;
            if (! $attributes) {
                continue;
            }

            $appMetadata = $attributes['application_metadata'] ?? [];
            $chainData = $item['relationships']['chain']['data'] ?? [];
            $dappData = $item['relationships']['dapp']['data'] ?? [];

            $network = $chainData['id'] ?? 'ethereum';
            $protocolSlug = $dappData['id'] ?? $attributes['protocol'] ?? Str::slug($appMetadata['name'] ?? $attributes['name'] ?? 'unknown');
            $protocolName = $appMetadata['name'] ?? $attributes['name'] ?? 'Desconhecido';
            $protocolLogoUrl = $appMetadata['icon']['url'] ?? null;
            $positionType = $attributes['position_type'] ?? $attributes['protocol_module'] ?? 'DeFi';
            $totalValueUsd = $attributes['value'] ?? 0;

            WalletDefiPosition::updateOrCreate(
                [
                    'wallet_id' => $wallet->id,
                    'protocol_slug' => $protocolSlug,
                    'network' => $network,
                ],
                [
                    'protocol_name' => $protocolName,
                    'protocol_logo_url' => $protocolLogoUrl,
                    'position_type' => $positionType,
                    'total_value_usd' => $totalValueUsd,
                    'deposited_value_usd' => $totalValueUsd,
                    'rewards_value_usd' => 0,
                    'assets_data' => $attributes,
                    'synced_at' => now(),
                ]
            );

            $count++;
        }

        return $count;
    }

    /**
     * Processa e salva NFTs na tabela `wallet_nfts`
     */
    public function saveNfts(Wallet $wallet, array $apiResponse): int
    {
        $items = $apiResponse['data'] ?? [];
        $count = 0;

        foreach ($items as $item) {
            $attributes = $item['attributes'] ?? null;
            if (! $attributes) {
                continue;
            }

            $nftInfo = $attributes['nft_info'] ?? [];
            $chainData = $item['relationships']['chain']['data'] ?? [];

            $network = $chainData['id'] ?? 'ethereum';
            $collectionAddress = $nftInfo['contract_address'] ?? '0x0000000000000000000000000000000000000000';
            $tokenId = (string) ($nftInfo['token_id'] ?? $count);

            $imageUrl = $nftInfo['content']['preview']['url'] ?? $nftInfo['content']['detail']['url'] ?? null;
            $floorPrice = $attributes['price'] ?? $attributes['value'] ?? 0;
            $estimatedValue = $attributes['value'] ?? $attributes['price'] ?? 0;

            WalletNft::updateOrCreate(
                [
                    'wallet_id' => $wallet->id,
                    'collection_address' => $collectionAddress,
                    'token_id' => $tokenId,
                ],
                [
                    'collection_name' => $nftInfo['name'] ?? 'NFT Collection',
                    'image_url' => $imageUrl,
                    'floor_price_usd' => $floorPrice,
                    'estimated_value_usd' => $estimatedValue,
                    'network' => $network,
                    'metadata' => $nftInfo,
                    'synced_at' => now(),
                ]
            );

            $count++;
        }

        return $count;
    }

    /**
     * Processa e salva histórico de transações na tabela `wallet_transactions`
     */
    public function saveTransactions(Wallet $wallet, array $apiResponse): int
    {
        $items = $apiResponse['data'] ?? [];
        $count = 0;

        foreach ($items as $item) {
            $attributes = $item['attributes'] ?? null;
            if (! $attributes) {
                continue;
            }

            $hash = $attributes['hash'] ?? null;
            if (! $hash) {
                if (preg_match('/(0x[a-fA-F0-9]{64})/', $item['id'] ?? '', $matches)) {
                    $hash = $matches[1];
                } else {
                    continue;
                }
            }

            $chainData = $item['relationships']['chain']['data'] ?? [];
            $network = $chainData['id'] ?? 'ethereum';

            $operationType = strtolower($attributes['operation_type'] ?? $item['type'] ?? 'unknown');
            $status = $attributes['status'] ?? 'confirmed';
            $minedAt = $attributes['mined_at'] ?? now()->toIso8601String();
            $transactionAt = Carbon::parse($minedAt);

            $fee = $attributes['fee'] ?? [];
            $gasFeeUsd = isset($fee['value']) ? (float) $fee['value'] : null;

            $transfers = $attributes['transfers'] ?? [];
            $sent = [];
            $received = [];
            $totalSentUsd = 0.0;
            $totalReceivedUsd = 0.0;

            foreach ($transfers as $t) {
                $direction = strtolower($t['direction'] ?? '');
                $fungible = $t['fungible_info'] ?? null;
                $nft = $t['nft_info'] ?? null;

                $symbol = $fungible['symbol'] ?? ($nft ? ($nft['name'] ?? 'NFT') : 'UNKNOWN');
                $name = $fungible['name'] ?? ($nft['name'] ?? null);
                $iconUrl = $fungible['icon']['url'] ?? ($nft['content']['preview']['url'] ?? null);

                $amount = isset($t['quantity']['float'])
                    ? (float) $t['quantity']['float']
                    : (isset($t['quantity']['numeric']) && isset($t['quantity']['decimals'])
                        ? (float) $t['quantity']['numeric'] / (10 ** (int) $t['quantity']['decimals'])
                        : (float) ($t['quantity'] ?? 0));

                $valueUsd = isset($t['value']) ? (float) $t['value'] : (isset($t['price']) ? $amount * (float) $t['price'] : null);

                $summaryItem = [
                    'symbol' => $symbol,
                    'name' => $name,
                    'amount' => $amount,
                    'value_usd' => $valueUsd,
                    'icon_url' => $iconUrl,
                    'is_nft' => ! empty($nft),
                ];

                if ($direction === 'out') {
                    $sent[] = $summaryItem;
                    if ($valueUsd) {
                        $totalSentUsd += $valueUsd;
                    }
                } elseif ($direction === 'in') {
                    $received[] = $summaryItem;
                    if ($valueUsd) {
                        $totalReceivedUsd += $valueUsd;
                    }
                }
            }

            $transactionValueUsd = max($totalReceivedUsd, $totalSentUsd);
            if ($transactionValueUsd === 0.0 && isset($attributes['value'])) {
                $transactionValueUsd = (float) $attributes['value'];
            }

            $friendlyDescription = $this->buildFriendlyDescription($operationType, $sent, $received);

            // Regra: Transações são imutáveis. Inserir idempotente sem duplicar (unique por wallet_id + tx_hash)
            WalletTransaction::firstOrCreate(
                [
                    'wallet_id' => $wallet->id,
                    'tx_hash' => $hash,
                ],
                [
                    'network' => $network,
                    'transaction_at' => $transactionAt,
                    'action_type' => $operationType,
                    'friendly_description' => $friendlyDescription,
                    'gas_fee_usd' => $gasFeeUsd,
                    'transaction_value_usd' => $transactionValueUsd > 0 ? $transactionValueUsd : null,
                    'status' => $status,
                    'asset_deltas' => [
                        'sent' => $sent,
                        'received' => $received,
                    ],
                    'raw_data' => $attributes,
                ]
            );

            $count++;
        }

        return $count;
    }


    protected function buildFriendlyDescription(string $operationType, array $sent, array $received): string
    {
        $formatAmount = function (float $amount, string $symbol): string {
            $formatted = $amount >= 1 ? number_format($amount, 2, ',', '.') : rtrim(rtrim(number_format($amount, 6, ',', '.'), '0'), ',');
            return "{$formatted} {$symbol}";
        };

        return match ($operationType) {
            'trade', 'swap' => ! empty($sent) && ! empty($received)
                ? "Troca de {$formatAmount($sent[0]['amount'], $sent[0]['symbol'])} por {$formatAmount($received[0]['amount'], $received[0]['symbol'])}"
                : 'Troca de ativos (Swap)',

            'send' => ! empty($sent)
                ? "Envio de {$formatAmount($sent[0]['amount'], $sent[0]['symbol'])}"
                : 'Envio de ativos',

            'receive' => ! empty($received)
                ? "Recebimento de {$formatAmount($received[0]['amount'], $received[0]['symbol'])}"
                : 'Recebimento de ativos',

            'deposit' => ! empty($sent)
                ? "Depósito de {$formatAmount($sent[0]['amount'], $sent[0]['symbol'])} em protocolo"
                : 'Depósito em protocolo DeFi',

            'withdraw' => ! empty($received)
                ? "Resgate de {$formatAmount($received[0]['amount'], $received[0]['symbol'])} de protocolo"
                : 'Resgate de protocolo DeFi',

            'mint' => ! empty($received)
                ? 'Mint de ' . $received[0]['symbol']
                : 'Mint on-chain',

            'burn' => ! empty($sent)
                ? 'Queima de ' . $sent[0]['symbol']
                : 'Queima de tokens (Burn)',

            'approve' => 'Aprovação de contrato (' . ($sent[0]['symbol'] ?? $received[0]['symbol'] ?? 'Token') . ')',

            'execution' => 'Execução de contrato inteligente',

            default => ucfirst($operationType) . ' on-chain',
        };
    }

    /**
     * Grava um novo snapshot após a sincronização
     */
    protected function createSnapshotAfterSync(Wallet $wallet): void
    {
        $tokensUsd = (float) WalletTokenBalance::where('wallet_id', $wallet->id)->sum('balance_usd');
        $defiUsd = (float) WalletDefiPosition::where('wallet_id', $wallet->id)->sum('total_value_usd');
        $nftsUsd = (float) WalletNft::where('wallet_id', $wallet->id)->sum('estimated_value_usd');
        $totalNetWorth = $tokensUsd + $defiUsd + $nftsUsd;

        WalletSnapshot::create([
            'id' => (string) Str::uuid(),
            'wallet_id' => $wallet->id,
            'network' => 'all',
            'snapshot_at' => now(),
            'total_net_worth_usd' => $totalNetWorth,
            'tokens_usd' => $tokensUsd,
            'defi_usd' => $defiUsd,
            'nfts_usd' => $nftsUsd,
            'btc_benchmark_usd' => 67000,
        ]);
    }

    /**
     * Grava log de sincronização na tabela `zerion_sync_logs`
     */
    protected function logSync(string $walletId, string $endpoint, string $status, ?string $errorMessage, float $startTime): void
    {
        $responseTimeMs = (int) round((microtime(true) - $startTime) * 1000);

        DB::table('zerion_sync_logs')->insert([
            'id' => (string) Str::uuid(),
            'wallet_id' => $walletId,
            'endpoint' => $endpoint,
            'credits_used' => 1,
            'response_time_ms' => $responseTimeMs,
            'status' => $status,
            'error_message' => $errorMessage,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
