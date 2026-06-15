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
        Schema::create('wallet_defi_positions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('wallet_id')->constrained('wallets')->cascadeOnDelete();
            $table->string('protocol_name', 150);
            $table->string('protocol_slug', 100)->nullable();
            $table->string('protocol_logo_url', 1000)->nullable();
            $table->string('network', 50);
            $table->string('position_type', 50);
            $table->decimal('total_value_usd', 24, 8);
            $table->decimal('deposited_value_usd', 24, 8)->nullable();
            $table->decimal('rewards_value_usd', 24, 8)->nullable();
            $table->decimal('apr', 12, 4)->nullable();
            $table->jsonb('assets_data')->nullable();
            $table->timestamp('synced_at');
            $table->timestamps();
            $table->softDeletes();
            $table->index([
                'wallet_id',
                'network'
            ]);

            $table->index('protocol_name');
            $table->index('position_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_defi_positions');
    }
};
