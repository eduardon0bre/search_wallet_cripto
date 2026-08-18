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
        if (Schema::hasTable('zapper_sync_logs')) {
            Schema::rename('zapper_sync_logs', 'zerion_sync_logs');
        } elseif (!Schema::hasTable('zerion_sync_logs')) {
            Schema::create('zerion_sync_logs', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->foreignUuid('wallet_id')
                    ->constrained('wallets')
                    ->cascadeOnDelete();

                $table->string('endpoint', 100);
                $table->integer('credits_used')
                    ->default(0);

                $table->integer('response_time_ms')
                    ->nullable();

                $table->enum('status', [
                    'success',
                    'error'
                ]);

                $table->text('error_message')
                    ->nullable();

                $table->timestamps();
                $table->index([
                    'wallet_id',
                    'status'
                ]);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
