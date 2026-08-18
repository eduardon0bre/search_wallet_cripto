<?php

namespace App\Services;

use App\Models\Models\WalletsWeb3\Wallet;
use App\Models\Models\WalletsWeb3\WalletTokenBalance;
use App\Models\Models\WalletsWeb3\WalletDefiPosition;
use App\Models\Models\WalletsWeb3\WalletNft;
use App\Models\Models\WalletsWeb3\WalletSnapshot;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
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
            'status' => 'success',
            'errors' => [],
        ];

        $address = trim($wallet->wallet_address ?? '');

        // Validação de formato EVM (0x + 40 hex chars) ou ENS (.eth)
        if (!preg_match('/^(0x[a-fA-F0-9]{40}|[a-zA-Z0-9-]+\.eth)$/i', $address)) {
            $errorMsg = "Endereço da carteira é inválido: '{$address}'. O formato deve ser um endereço EVM válido (ex: 0x...) ou ENS (.eth).";
            $syncResults['errors'][] = $errorMsg;
            $syncResults['status'] = 'error';
            $this->logSync($wallet->id, 'validateAddress', 'error', $errorMsg, $startTime);
            Log::warning("Tentativa de sincronizar carteira {$wallet->id} com endereço inválido: {$address}");
            return $syncResults;
        }
            $tokenData = $this->zerionService->getTokens($wallet->wallet_address);

            // 1. Sincronizar Tokens
        try {
            $tokenData = $this->zerionService->getTokens($wallet->wallet_address);
            $syncResults['tokens_count'] = $this->saveTokenBalances($wallet, $tokenData);
            $this->logSync($wallet->id, 'getTokens', 'success', null, $startTime);
        } catch (\Throwable $e) {
            $syncResults['errors'][] = 'Tokens: ' . $e->getMessage();
            $this->logSync($wallet->id, 'getTokens', 'error', $e->getMessage(), $startTime);
            Log::error("Erro ao sincronizar tokens da carteira {$wallet->id}: " . $e->getMessage());
        }

        // 2. Sincronizar Posições DeFi
        try {
            $appData = $this->zerionService->getAppBalances($wallet->wallet_address);
            $syncResults['defi_count'] = $this->saveDefiPositions($wallet, $appData);
            $this->logSync($wallet->id, 'getAppBalances', 'success', null, $startTime);
        } catch (\Throwable $e) {
            $syncResults['errors'][] = 'DeFi: ' . $e->getMessage();
            $this->logSync($wallet->id, 'getAppBalances', 'error', $e->getMessage(), $startTime);
            Log::error("Erro ao sincronizar DeFi da carteira {$wallet->id}: " . $e->getMessage());
        }

        usleep(100000);

        try {
            $nftData = $this->zerionService->getNfts($wallet->wallet_address);
            $syncResults['nfts_count'] = $this->saveNfts($wallet, $nftData);
            $this->logSync($wallet->id, 'getNfts', 'success', null, $startTime);
        } catch (\Throwable $e) {
            $syncResults['errors'][] = 'NFTs: ' . $e->getMessage();
            $this->logSync($wallet->id, 'getNfts', 'error', $e->getMessage(), $startTime);
            Log::error("Erro ao sincronizar NFTs da carteira {$wallet->id}: " . $e->getMessage());
        }

        if (!empty($syncResults['errors']) && $syncResults['tokens_count'] === 0 && $syncResults['defi_count'] === 0 && $syncResults['nfts_count'] === 0) {
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
            if (!$attributes) continue;

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
            if (!$attributes) continue;

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
            if (!$attributes) continue;

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
