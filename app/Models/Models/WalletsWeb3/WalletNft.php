<?php

namespace App\Models\Models\WalletsWeb3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletNft extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'wallet_nfts';

    protected $fillable = [
        'wallet_id',
        'collection_name',
        'collection_address',
        'token_id',
        'image_url',
        'floor_price_usd',
        'estimated_value_usd',
        'rarity_rank',
        'network',
        'metadata',
        'synced_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'floor_price_usd' => 'decimal:8',
        'estimated_value_usd' => 'decimal:8',
        'synced_at' => 'datetime',
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function getNameAttribute(): string
    {
        return "{$this->collection_name} #{$this->token_id}";
    }
}