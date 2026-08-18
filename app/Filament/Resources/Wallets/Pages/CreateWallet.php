<?php

namespace App\Filament\Resources\Wallets\Pages;

use App\Filament\Resources\Wallets\WalletResource;
use App\Models\Models\WalletsWeb3\Wallet;
use App\Services\WalletService;
use Filament\Resources\Pages\CreateRecord;

class CreateWallet extends CreateRecord
{
    protected static string $resource = WalletResource::class;

    /**
     * Executado antes de criar o registro.
     * Aqui adicionamos automaticamente
     * o usuário autenticado.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

    /**
     * Executado após a criação da carteira no banco.
     */
    protected function afterCreate(): void
    {
        $wallet = $this->record;
        app(\App\Services\WalletSyncService::class)->syncWallet($wallet);
    }
}

