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
        Schema::create('wallet_token_balances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('wallet_id')
                ->constrained('wallets')
                ->cascadeOnDelete();

            $table->string('network', 50);
            $table->string('token_address', 100);
            $table->string('symbol', 30);
            $table->string('name', 255)
                ->nullable();

            $table->string('logo_url', 1000)
                ->nullable();

            $table->unsignedTinyInteger('decimals')
                ->nullable();

            $table->decimal('balance_quantity', 38, 18);

            $table->decimal('balance_usd', 24, 8)
                ->default(0);

            $table->decimal('token_price_usd', 24, 8)
                ->nullable();

            $table->timestamp('synced_at');
            $table->timestamps();
            $table->softDeletes();

            $table->unique([
                'wallet_id',
                'network',
                'token_address'
            ]);

            $table->index([
                'wallet_id',
                'network'
            ]);

            $table->index('symbol');
            $table->index('balance_usd');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_token_balances');
    }
};
