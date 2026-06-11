<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('wallet_id')
                ->constrained('wallets')
                ->cascadeOnDelete();

            $table->string('tx_hash', 100);
            $table->string('network', 50);
            $table->timestamp('transaction_at');
            $table->string('action_type', 50);
            $table->text('friendly_description');
            $table->decimal('gas_fee_usd', 24, 8)
                ->nullable();

            $table->json('asset_deltas')
                ->nullable();

            $table->timestamps();
            $table->unique([
                'wallet_id',
                'tx_hash'
            ]);

            $table->index([
                'wallet_id',
                'transaction_at'
            ]);

            $table->index('tx_hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
