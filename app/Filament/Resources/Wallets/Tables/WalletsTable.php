<?php

namespace App\Filament\Resources\Wallets\Tables;

use App\Services\WalletSyncService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class WalletsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('wallet_address')
                    ->label('Endereço')
                    ->searchable()
                    ->copyable()
                    ->limit(20),

                IconColumn::make('is_active')
                    ->label('Ativa')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Criada em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Atualizada em')
                    ->since(),
            ])

            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Status'),
            ])

            ->defaultSort('created_at', 'desc')

            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                Action::make('sync')
                    ->label('Sync')
                    ->icon('heroicon-o-arrow-path')
                    ->action(function ($record) {
                        $result = app(WalletSyncService::class)->syncWallet($record);

                        if ($result['status'] === 'success') {
                            Notification::make()
                                ->title('Carteira sincronizada com sucesso!')
                                ->body("Foram sincronizados: {$result['tokens_count']} tokens, {$result['defi_count']} posições DeFi, {$result['nfts_count']} NFTs e {$result['transactions_count']} transações.")
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Erro ou aviso na sincronização')
                                ->body(implode(' | ', $result['errors']))
                                ->warning()
                                ->send();
                        }
                    }),
            ])

            ->toolbarActions([

                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),

            ]);
    }
}