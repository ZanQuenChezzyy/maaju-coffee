<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID Pesanan')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->color('primary')
                    ->prefix('#ORD-'),
                TextColumn::make('table.name')
                    ->label('Meja')
                    ->searchable()
                    ->badge()
                    ->color('info')
                    ->default('Takeaway'),
                SelectColumn::make('payment_status')
                    ->label('Pembayaran')
                    ->options([
                        'unpaid' => 'Belum Lunas',
                        'paid' => 'Lunas',
                    ])
                    ->sortable(),
                ImageColumn::make('transaction.payment_receipt')
                    ->label('Bukti Transfer')
                    ->square()
                    ->defaultImageUrl(url('/images/placeholder-receipt.png')),
                SelectColumn::make('status')
                    ->label('Status Dapur')
                    ->options([
                        'pending' => 'Menunggu',
                        'cooking' => 'Sedang Diproses',
                        'ready' => 'Siap Diambil',
                        'completed' => 'Selesai',
                    ])
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_amount')
                    ->label('Total')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Waktu Pesan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Pesanan')
            ->emptyStateDescription('Pesanan yang masuk dari pelanggan akan muncul di sini.')
            ->emptyStateIcon('heroicon-o-shopping-bag');
    }
}
