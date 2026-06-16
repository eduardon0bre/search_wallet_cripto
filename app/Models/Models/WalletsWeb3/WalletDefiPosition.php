<?php

namespace App\Models\Models\WalletsWeb3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletDefiPosition extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'wallet_defi_positions';

    protected $fillable = [
        'wallet_id',
        'protocol_name',
        'protocol_slug',
        'protocol_logo_url',
        'network',
        'position_type',
        'total_value_usd',
        'deposited_value_usd',
        'rewards_value_usd',
        'apr',
        'assets_data',
        'synced_at',
    ];

    protected $casts = [
        'assets_data' => 'array',
        'total_value_usd' => 'decimal:8',
        'deposited_value_usd' => 'decimal:8',
        'rewards_value_usd' => 'decimal:8',
        'apr' => 'decimal:4',
        'synced_at' => 'datetime',
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function getTotalRewardsAttribute(): float
    {
        return (float) ($this->rewards_value_usd ?? 0);
    }
}