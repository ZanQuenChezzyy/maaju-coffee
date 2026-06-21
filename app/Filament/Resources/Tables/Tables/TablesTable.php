<?php

namespace App\Filament\Resources\Tables\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TablesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nomor / Nama Meja')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('primary'),
                TextColumn::make('qr_code_url')
                    ->label('Tautan QR Code')
                    ->searchable()
                    ->limit(50)
                    ->color('gray')
                    ->default('-'),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('printQr')
                    ->label('Cetak QR')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->url(fn(\App\Models\Table $record) => route('table.print-qr', $record))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Meja')
            ->emptyStateDescription('Tambahkan meja untuk mengatur sistem pemesanan via QR Code.')
            ->emptyStateIcon('heroicon-o-squares-2x2');
    }
}
