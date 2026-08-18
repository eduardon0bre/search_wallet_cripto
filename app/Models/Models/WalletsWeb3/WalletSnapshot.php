<?php

namespace App\Models\Models\WalletsWeb3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletSnapshot extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'wallet_snapshots';

    protected $fillable = [
        'wallet_id',
        'network',
        'snapshot_at',
        'total_net_worth_usd',
        'tokens_usd',
        'defi_usd',
        'nfts_usd',
        'btc_benchmark_usd',
    ];

    protected $casts = [
        'snapshot_at' => 'datetime',
        'total_net_worth_usd' => 'decimal:8',
        'tokens_usd' => 'decimal:8',
        'defi_usd' => 'decimal:8',
        'nfts_usd' => 'decimal:8',
        'btc_benchmark_usd' => 'decimal:8',
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
