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
        return substr($this->tx_hash, 0, 10)
            . '...'
            . substr($this->tx_hash, -8);
    }

    public function isSwap(): bool
    {
        return strtolower($this->action_type) === 'swap';
    }

    public function isSend(): bool
    {
        return strtolower($this->action_type) === 'send';
    }

    public function isReceive(): bool
    {
        return strtolower($this->action_type) === 'receive';
    }
}