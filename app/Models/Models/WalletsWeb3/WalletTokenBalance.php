<?php

namespace App\Models\Models\WalletsWeb3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTokenBalance extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'wallet_token_balances';

    protected $fillable = [
        'wallet_id',
        'network',
        'token_address',
        'symbol',
        'name',
        'logo_url',
        'decimals',
        'balance_quantity',
        'balance_usd',
        'token_price_usd',
        'synced_at',
    ];

    protected $casts = [
        'balance_quantity' => 'decimal:18',
        'balance_usd' => 'decimal:8',
        'token_price_usd' => 'decimal:8',
        'decimals' => 'integer',
        'synced_at' => 'datetime',
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function getFormattedBalanceUsdAttribute(): string
    {
        return '$ ' . number_format(
            (float) $this->balance_usd,
            2,
            '.',
            ','
        );
    }
}