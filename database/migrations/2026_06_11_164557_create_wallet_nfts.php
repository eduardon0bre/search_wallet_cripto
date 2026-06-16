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
        Schema::create('wallet_nfts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('wallet_id')->constrained('wallets')->cascadeOnDelete();
            $table->string('collection_name', 255);
            $table->string('collection_address', 100);
            $table->string('token_id', 255);
            $table->string('image_url', 1000)->nullable();
            $table->decimal('floor_price_usd', 24, 8)->nullable();
            $table->decimal('estimated_value_usd', 24, 8)->nullable();
            $table->string('rarity_rank', 100)->nullable();
            $table->string('network', 50);
            $table->jsonb('metadata')->nullable();
            $table->timestamp('synced_at');
            $table->timestamps();
            $table->softDeletes();
            $table->unique([
                'wallet_id',
                'collection_address',
                'token_id'
            ]);

            $table->index([
                'wallet_id',
                'network'
            ]);

            $table->index('collection_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_nfts');
    }
};
