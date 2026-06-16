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
            $table->string('tx_hash', 255);
            $table->string('network', 50);
            $table->timestamp('transaction_at');
            $table->string('action_type', 50);
            $table->text('friendly_description');
            $table->decimal('gas_fee_usd', 24, 8)->nullable();
            $table->decimal('transaction_value_usd', 24, 8)->nullable();
            $table->string('status', 30)->default('confirmed');
            $table->jsonb('asset_deltas')->nullable();
            $table->jsonb('raw_data')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique([
                'wallet_id',
                'tx_hash'
            ]);

            $table->index([
                'wallet_id',
                'transaction_at'
            ]);

            $table->index('tx_hash');
            $table->index('action_type');
            $table->index('status');
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
