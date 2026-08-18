<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class ZerionService
{
    public function __construct(
        protected ?string $baseUrl = null,
        protected ?string $apiKey = null,
    ) {
        $this->baseUrl = $this->baseUrl ?? config('services.zerion.base_url', 'https://api.zerion.io/v1');
        $this->apiKey = $this->apiKey ?? config('services.zerion.api_key');
    }

    /**
     * Retorna o cliente HTTP autenticado via HTTP Basic Auth.
     */
    protected function client()
    {
        return Http::withBasicAuth($this->apiKey, '')
            ->timeout(60)
            ->retry(3, 1000)
            ->acceptJson();
    }

    /**
     * Realiza uma requisição GET e lida com erros da API da Zerion.
     */
    protected function get(string $endpoint, array $queryParams = []): array
    {
        $url = rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/');

        $response = $this->client()->get($url, $queryParams);

        if ($response->failed()) {
            $data = $response->json();
            $detail = $data['errors'][0]['detail']
                ?? $data['errors'][0]['title']
                ?? $data['message']
                ?? null;

            if ($response->status() === 429 || str_contains(strtolower($detail ?? ''), 'throttled')) {
                throw new \RuntimeException("Limite de requisições excedido na Zerion API (Rate Limit). Aguarde alguns segundos e tente novamente.");
            }

            if ($detail) {
                if (str_contains(strtolower($detail), 'wallet address')) {
                    throw new \RuntimeException("Endereço de carteira inválido na Zerion API: {$detail}");
                }
                throw new \RuntimeException("Erro Zerion API: {$detail}");
            }

            throw new RequestException($response);
        }

        return $response->json() ?? [];
    }

    /**
     * Resumo consolidado do portfolio da carteira.
     * GET /v1/wallets/{address}/portfolio
     */
    public function getPortfolio(string $walletAddress): array
    {
        return $this->get("wallets/{$walletAddress}/portfolio", [
            'currency' => 'usd',
        ]);
    }

    /**
     * Busca os saldos de tokens da carteira (limite de 100 tokens por página).
     * GET /v1/wallets/{address}/positions/?filter[positions]=only_simple
     */
    public function getTokens(string $walletAddress, int $pageSize = 100): array
    {
        return $this->get("wallets/{$walletAddress}/positions/", [
            'currency' => 'usd',
            'filter[positions]' => 'only_simple',
            'filter[trash]' => 'only_non_trash',
            'sort' => 'value',
            'page[size]' => $pageSize,
        ]);
    }

    /**
     * Busca posições em protocolos DeFi.
     * GET /v1/wallets/{address}/positions/?filter[positions]=only_complex
     */
    public function getAppBalances(string $walletAddress, int $pageSize = 100): array
    {
        return $this->get("wallets/{$walletAddress}/positions/", [
            'currency' => 'usd',
            'filter[positions]' => 'only_complex',
            'sort' => 'value',
            'page[size]' => $pageSize,
        ]);
    }

    /**
     * Busca NFTs pertencentes à carteira.
     * GET /v1/wallets/{address}/nft-positions/
     */
    public function getNfts(string $walletAddress, int $pageSize = 100): array
    {
        return $this->get("wallets/{$walletAddress}/nft-positions/", [
            'currency' => 'usd',
            'sort' => '-floor_price',
            'page[size]' => $pageSize,
        ]);
    }

    /**
     * Busca o histórico de transações da carteira.
     * GET /v1/wallets/{address}/transactions/
     */
    public function getTransactions(string $walletAddress, int $pageSize = 20): array
    {
        return $this->get("wallets/{$walletAddress}/transactions/", [
            'currency' => 'usd',
            'page[size]' => $pageSize,
        ]);
    }
}
