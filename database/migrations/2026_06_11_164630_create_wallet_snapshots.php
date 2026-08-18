<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallet_snapshots', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('wallet_id')
                ->constrained('wallets')
                ->cascadeOnDelete();
            $table->string('network', 50)->default('all');
            $table->timestamp('snapshot_at');
            $table->decimal('total_net_worth_usd', 24, 8);
            $table->decimal('tokens_usd', 24, 8)->default(0);
            $table->decimal('defi_usd', 24, 8)->default(0);
            $table->decimal('nfts_usd', 24, 8)->default(0);
            $table->decimal('btc_benchmark_usd', 24, 8)->default(0);
            $table->timestamps();

            $table->index(['wallet_id', 'network', 'snapshot_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_snapshots');
    }
};
