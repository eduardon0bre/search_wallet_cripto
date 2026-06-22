<?php

namespace App\Filament\Resources\Wallets\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WalletForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /**
                 * Nome amigável da carteira.
                 *
                 * Ex:
                 * Carteira Principal
                 * Ledger
                 * Wallet Teste
                 */
                TextInput::make('label')
                    ->label('Nome')
                    ->maxLength(100),

                /**
                 * Endereço público da wallet.
                 *
                 * Este endereço será utilizado
                 * posteriormente para consultar
                 * dados na API da Zapper.
                 */
                TextInput::make('wallet_address')
                    ->label('Endereço da Carteira')
                    ->required()
                    ->maxLength(120)
                    ->unique(ignoreRecord: true),

            ]);
    }
}