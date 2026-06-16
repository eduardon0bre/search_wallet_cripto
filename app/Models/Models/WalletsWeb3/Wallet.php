<?php

namespace App\Models\Models\WalletsWeb3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'wallets';

    protected $fillable = [
        'user_id',
        'wallet_address',
        'label',
        'last_sync_at',
    ];

    protected $casts = [
        'last_sync_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tokenBalances(): HasMany
    {
        return $this->hasMany(WalletTokenBalance::class);
    }

    public function defiPositions(): HasMany
    {
        return $this->hasMany(WalletDefiPosition::class);
    }

    public function nfts(): HasMany
    {
        return $this->hasMany(WalletNft::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function getShortAddressAttribute(): string
    {
        return substr($this->wallet_address, 0, 6)
            . '...'
            . substr($this->wallet_address, -4);
    }

    public function needsSync(int $minutes = 5): bool
    {
        if (!$this->last_sync_at) {
            return true;
        }

        return $this->last_sync_at->diffInMinutes(now()) >= $minutes;
    }

    public function markAsSynced(): void
    {
        $this->update([
            'last_sync_at' => now(),
        ]);
    }
}