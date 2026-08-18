<?php

namespace App\Services;

use App\Models\Models\WalletsWeb3\Wallet;
use App\Models\Models\WalletsWeb3\WalletTokenBalance;
use App\Models\Models\WalletsWeb3\WalletDefiPosition;
use App\Models\Models\WalletsWeb3\WalletNft;
use App\Models\Models\WalletsWeb3\WalletSnapshot;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WalletSyncService
{
    public function __construct(
        protected ZapperService $zapperService
    ) {}

    /**
     * Sincroniza todas as informações de uma carteira (Tokens, DeFi, NFTs)
     */
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

        // 1. Sincronizar Tokens
        try {
            $tokenData = $this->zapperService->getTokens($wallet->wallet_address);
            $syncResults['tokens_count'] = $this->saveTokenBalances($wallet, $tokenData);
            $this->logSync($wallet->id, 'getTokens', 'success', null, $startTime);
        } catch (\Throwable $e) {
            $syncResults['errors'][] = 'Tokens: ' . $e->getMessage();
            $this->logSync($wallet->id, 'getTokens', 'error', $e->getMessage(), $startTime);
            Log::error("Erro ao sincronizar tokens da carteira {$wallet->id}: " . $e->getMessage());
        }

        // 2. Sincronizar Posições DeFi
        try {
            $appData = $this->zapperService->getAppBalances($wallet->wallet_address);
            $syncResults['defi_count'] = $this->saveDefiPositions($wallet, $appData);
            $this->logSync($wallet->id, 'getAppBalances', 'success', null, $startTime);
        } catch (\Throwable $e) {
            $syncResults['errors'][] = 'DeFi: ' . $e->getMessage();
            $this->logSync($wallet->id, 'getAppBalances', 'error', $e->getMessage(), $startTime);
            Log::error("Erro ao sincronizar DeFi da carteira {$wallet->id}: " . $e->getMessage());
        }

        // 3. Sincronizar NFTs
        try {
            $nftData = $this->zapperService->getNfts($wallet->wallet_address);
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
        $edges = $apiResponse['portfolioV2']['tokenBalances']['byToken']['edges'] ?? [];
        $count = 0;

        foreach ($edges as $edge) {
            $node = $edge['node'] ?? null;
            if (!$node) continue;

            $network = $node['network']['slug'] ?? $node['network']['name'] ?? 'ethereum';
            $tokenAddress = $node['tokenAddress'] ?? '0x0000000000000000000000000000000000000000';

            WalletTokenBalance::updateOrCreate(
                [
                    'wallet_id' => $wallet->id,
                    'network' => $network,
                    'token_address' => $tokenAddress,
                ],
                [
                    'symbol' => $node['symbol'] ?? 'UNKNOWN',
                    'name' => $node['name'] ?? null,
                    'logo_url' => $node['imgUrlV2'] ?? null,
                    'decimals' => $node['decimals'] ?? 18,
                    'balance_quantity' => $node['balance'] ?? 0,
                    'balance_usd' => $node['balanceUSD'] ?? 0,
                    'token_price_usd' => $node['price'] ?? null,
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
        $edges = $apiResponse['portfolioV2']['appBalances']['byApp']['edges'] ?? [];
        $count = 0;

        foreach ($edges as $edge) {
            $node = $edge['node'] ?? null;
            if (!$node) continue;

            $app = $node['app'] ?? [];
            $network = $node['network']['slug'] ?? 'ethereum';
            $protocolSlug = $app['slug'] ?? Str::slug($app['displayName'] ?? 'unknown');

            WalletDefiPosition::updateOrCreate(
                [
                    'wallet_id' => $wallet->id,
                    'protocol_slug' => $protocolSlug,
                    'network' => $network,
                ],
                [
                    'protocol_name' => $app['displayName'] ?? 'Desconhecido',
                    'protocol_logo_url' => $app['imgUrl'] ?? null,
                    'position_type' => $app['category']['name'] ?? 'DeFi',
                    'total_value_usd' => $node['balanceUSD'] ?? 0,
                    'deposited_value_usd' => $node['balanceUSD'] ?? 0,
                    'rewards_value_usd' => 0,
                    'assets_data' => $app,
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
        $edges = $apiResponse['portfolioV2']['nftBalances']['byToken']['edges'] ?? [];
        $count = 0;

        foreach ($edges as $edge) {
            $node = $edge['node'] ?? null;
            $token = $node['token'] ?? null;
            if (!$token) continue;

            $collection = $token['collection'] ?? [];
            $collectionAddress = $collection['address'] ?? '0x0000000000000000000000000000000000000000';
            $tokenId = $token['tokenId'] ?? (string)$count;

            $imageUrl = null;
            $mediaEdges = $token['mediasV3']['images']['edges'] ?? [];
            if (!empty($mediaEdges[0]['node']['original'])) {
                $imageUrl = $mediaEdges[0]['node']['original'];
            } elseif (!empty($mediaEdges[0]['node']['thumbnail'])) {
                $imageUrl = $mediaEdges[0]['node']['thumbnail'];
            }

            WalletNft::updateOrCreate(
                [
                    'wallet_id' => $wallet->id,
                    'collection_address' => $collectionAddress,
                    'token_id' => $tokenId,
                ],
                [
                    'collection_name' => $collection['name'] ?? 'NFT Collection',
                    'image_url' => $imageUrl,
                    'floor_price_usd' => $token['estimatedValue']['valueUsd'] ?? 0,
                    'estimated_value_usd' => $token['estimatedValue']['valueUsd'] ?? 0,
                    'network' => $collection['network'] ?? 'ethereum',
                    'metadata' => $token,
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
     * Grava log de sincronização na tabela `zapper_sync_logs`
     */
    protected function logSync(string $walletId, string $endpoint, string $status, ?string $errorMessage, float $startTime): void
    {
        $responseTimeMs = (int) round((microtime(true) - $startTime) * 1000);

        DB::table('zapper_sync_logs')->insert([
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
