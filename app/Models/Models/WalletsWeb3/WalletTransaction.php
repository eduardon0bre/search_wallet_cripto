<?php

namespace App\Models\Models\WalletsWeb3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'wallet_transactions';

    protected $fillable = [
        'wallet_id',
        'tx_hash',
        'network',
        'transaction_at',
        'action_type',
        'friendly_description',
        'gas_fee_usd',
        'transaction_value_usd',
        'status',
        'asset_deltas',
        'raw_data',
    ];

    protected $casts = [
        'transaction_at' => 'datetime',
        'gas_fee_usd' => 'decimal:8',
        'transaction_value_usd' => 'decimal:8',
        'asset_deltas' => 'array',
        'raw_data' => 'array',
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function getShortHashAttribute(): string
    {
        if (! $this->tx_hash || strlen($this->tx_hash) <= 16) {
            return $this->tx_hash ?? '-';
        }

        return substr($this->tx_hash, 0, 10)
            . '...'
            . substr($this->tx_hash, -8);
    }

    public function getExplorerUrlAttribute(): string
    {
        $network = strtolower($this->network ?? 'ethereum');
        $hash = $this->tx_hash;

        return match ($network) {
            'ethereum', 'eth', 'mainnet' => "https://etherscan.io/tx/{$hash}",
            'polygon', 'matic' => "https://polygonscan.com/tx/{$hash}",
            'arbitrum', 'arbitrum-one' => "https://arbiscan.io/tx/{$hash}",
            'optimism', 'optimistic-ethereum', 'op' => "https://optimistic.etherscan.io/tx/{$hash}",
            'base' => "https://basescan.org/tx/{$hash}",
            'binance-smart-chain', 'bsc', 'bnb' => "https://bscscan.com/tx/{$hash}",
            'avalanche', 'avax' => "https://snowtrace.io/tx/{$hash}",
            'solana' => "https://solscan.io/tx/{$hash}",
            'linea' => "https://lineascan.build/tx/{$hash}",
            'blast' => "https://blastscan.io/tx/{$hash}",
            'zksync', 'zksync-era' => "https://era.zksync.network/tx/{$hash}",
            'scroll' => "https://scrollscan.com/tx/{$hash}",
            'fantom' => "https://ftmscan.com/tx/{$hash}",
            'gnosis' => "https://gnosisscan.io/tx/{$hash}",
            'polygon-zkevm' => "https://zkevm.polygonscan.com/tx/{$hash}",
            default => "https://etherscan.io/tx/{$hash}",
        };
    }

    public function isSwap(): bool
    {
        return in_array(strtolower($this->action_type ?? ''), ['swap', 'trade']);
    }

    public function isSend(): bool
    {
        return in_array(strtolower($this->action_type ?? ''), ['send', 'sell']);
    }

    public function isReceive(): bool
    {
        return in_array(strtolower($this->action_type ?? ''), ['receive', 'buy']);
    }
}