<?php

namespace App\Filament\Resources\Wallets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
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

                /**
                 * Nome amigável da carteira.
                 *
                 * Ex:
                 * Carteira Principal
                 * Ledger
                 * Wallet de Testes
                 *
                 * Caso o usuário não informe um nome,
                 * a coluna ficará vazia.
                 */
                TextColumn::make('label')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                /**
                 * Endereço da carteira.
                 *
                 * É o dado mais importante da entidade.
                 *
                 * searchable():
                 * Permite pesquisar pelo endereço.
                 *
                 * copyable():
                 * Adiciona botão de copiar.
                 *
                 * limit():
                 * Evita poluir a tela com endereços enormes.
                 */
                TextColumn::make('wallet_address')
                    ->label('Endereço')
                    ->searchable()
                    ->copyable()
                    ->limit(20),

                /**
                 * Status da carteira.
                 *
                 * Verde = ativa
                 * Vermelho = inativa
                 */
                IconColumn::make('is_active')
                    ->label('Ativa')
                    ->boolean(),

                /**
                 * Data de criação.
                 *
                 * Exibe quando a carteira foi cadastrada.
                 */
                TextColumn::make('created_at')
                    ->label('Criada em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                /**
                 * Data da última alteração.
                 *
                 * Útil para auditoria.
                 */
                TextColumn::make('updated_at')
                    ->label('Atualizada em')
                    ->since(),
            ])

            ->filters([

                /**
                 * Filtro de status.
                 *
                 * Permite visualizar:
                 *
                 * - Apenas ativas
                 * - Apenas inativas
                 * - Todas
                 */
                TernaryFilter::make('is_active')
                    ->label('Status'),

            ])

            /**
             * Ordenação padrão.
             *
             * Carteiras mais recentes aparecem primeiro.
             */
            ->defaultSort('created_at', 'desc')

            ->recordActions([

                /**
                 * Visualizar detalhes da carteira.
                 */
                ViewAction::make(),

                /**
                 * Editar carteira.
                 */
                EditAction::make(),

            ])

            ->toolbarActions([

                /**
                 * Ações em massa.
                 *
                 * Atualmente apenas exclusão.
                 *
                 * Futuramente podemos adicionar:
                 *
                 * - Sincronizar selecionadas
                 * - Ativar selecionadas
                 * - Desativar selecionadas
                 */
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),

            ]);
    }
}