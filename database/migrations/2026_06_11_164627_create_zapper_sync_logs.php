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
        Schema::create('zapper_sync_logs', function (Blueprint $table) {
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zapper_sync_logs');
    }
};
