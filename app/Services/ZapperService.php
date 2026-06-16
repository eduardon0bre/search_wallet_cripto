<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class ZapperService
{
    public function __construct(
        protected ?string $endpoint = null,
        protected ?string $apiKey = null,
    ) {
        $this->endpoint = $this->endpoint ?? config('services.zapper.endpoint');
        $this->apiKey = $this->apiKey ?? config('services.zapper.api_key');
    }

    protected function graphql(string $query, array $variables = []): array
    {
        $response = Http::withHeaders([
            'x-zapper-api-key' => $this->apiKey,
        ])
            ->timeout(60)
            ->post($this->endpoint, [
                'query' => $query,
                'variables' => $variables,
            ]);

        if ($response->failed()) {
            throw new RequestException($response);
        }

        $data = $response->json();

        if (isset($data['errors'])) {
            throw new \Exception(
                collect($data['errors'])
                    ->pluck('message')
                    ->join(', ')
            );
        }

        return $data['data'] ?? [];
    }

    /**
     * Resumo completo do portfolio
     */
    public function getPortfolio(
        string $walletAddress,
        array $chainIds = []
    ): array {
        $query = <<<'GRAPHQL'
query PortfolioTotals(
    $addresses: [Address!]!,
    $chainIds: [Int!]
) {
    portfolioV2(
        addresses: $addresses,
        chainIds: $chainIds
    ) {
        tokenBalances {
            totalBalanceUSD
        }

        nftBalances {
            totalBalanceUSD
            totalTokensOwned
        }

        appBalances {
            totalBalanceUSD
        }
    }
}
GRAPHQL;

        return $this->graphql($query, [
            'addresses' => [$walletAddress],
            'chainIds' => $chainIds ?: null,
        ]);
    }

    /**
     * Tokens
     */
    public function getTokens(
        string $walletAddress,
        int $first = 100,
        array $chainIds = []
    ): array {
        $query = <<<'GRAPHQL'
query TokenBalances(
    $addresses: [Address!]!,
    $first: Int,
    $chainIds: [Int!]
) {
    portfolioV2(
        addresses: $addresses,
        chainIds: $chainIds
    ) {
        tokenBalances {
            totalBalanceUSD

            byToken(
                first: $first,
                filters: {
                    minBalanceUSD: 1
                }
            ) {
                totalCount

                edges {
                    node {
                        tokenAddress
                        symbol
                        name
                        decimals
                        balance
                        balanceUSD
                        balanceRaw
                        price
                        imgUrlV2

                        network {
                            name
                            slug
                            chainId
                        }
                    }
                }
            }
        }
    }
}
GRAPHQL;

        return $this->graphql($query, [
            'addresses' => [$walletAddress],
            'first' => $first,
            'chainIds' => $chainIds ?: null,
        ]);
    }

    /**
     * DeFi / Apps
     */
    public function getAppBalances(
        string $walletAddress,
        int $first = 50,
        array $chainIds = []
    ): array {
        $query = <<<'GRAPHQL'
query AppBalances(
    $addresses: [Address!]!,
    $first: Int,
    $chainIds: [Int!]
) {
    portfolioV2(
        addresses: $addresses,
        chainIds: $chainIds
    ) {
        appBalances {

            totalBalanceUSD

            byApp(first: $first) {

                totalCount

                edges {
                    node {

                        balanceUSD

                        app {
                            displayName
                            slug
                            imgUrl
                            url
                            description

                            category {
                                name
                            }
                        }

                        network {
                            name
                            slug
                            chainId
                        }
                    }
                }
            }
        }
    }
}
GRAPHQL;

        return $this->graphql($query, [
            'addresses' => [$walletAddress],
            'first' => $first,
            'chainIds' => $chainIds ?: null,
        ]);
    }

    /**
     * NFTs
     */
    public function getNfts(
        string $walletAddress,
        int $first = 50,
        array $chainIds = []
    ): array {
        $query = <<<'GRAPHQL'
query NftBalances(
    $addresses: [Address!]!,
    $first: Int,
    $chainIds: [Int!]
) {
    portfolioV2(
        addresses: $addresses,
        chainIds: $chainIds
    ) {

        nftBalances {

            totalBalanceUSD

            totalTokensOwned

            byToken(
                first: $first,
                order: {
                    by: USD_WORTH
                }
            ) {

                edges {
                    node {

                        lastReceived

                        token {

                            tokenId
                            name
                            description

                            estimatedValue {
                                valueUsd
                            }

                            collection {
                                address
                                name
                                network
                            }

                            mediasV3 {
                                images {
                                    edges {
                                        node {
                                            original
                                            medium
                                            thumbnail
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
GRAPHQL;

        return $this->graphql($query, [
            'addresses' => [$walletAddress],
            'first' => $first,
            'chainIds' => $chainIds ?: null,
        ]);
    }
}
