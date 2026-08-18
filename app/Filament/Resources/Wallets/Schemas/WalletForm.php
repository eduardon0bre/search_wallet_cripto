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
                 * dados na API da Zerion.
                 */
                TextInput::make('wallet_address')
                    ->label('Endereço da Carteira (EVM ou ENS)')
                    ->placeholder('0x... ou nome.eth')
                    ->required()
                    ->regex('/^(0x[a-fA-F0-9]{40}|[a-zA-Z0-9-]+\.eth)$/i')
                    ->validationMessages([
                        'regex' => 'O endereço deve ser um endereço EVM válido (42 caracteres iniciando com 0x) ou um domínio ENS (.eth).',
                    ])
                    ->maxLength(120)
                    ->unique(ignoreRecord: true),

            ]);
    }
}