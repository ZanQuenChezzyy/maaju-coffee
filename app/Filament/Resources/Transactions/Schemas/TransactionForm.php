<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pembayaran')
                    ->description('Catatan transaksi yang terhubung dengan pesanan pelanggan.')
                    ->icon('heroicon-o-banknotes')
                    ->schema([
                        Select::make('order_id')
                            ->relationship('order', 'id')
                            ->label('ID Pesanan')
                            ->placeholder('Pilih ID pesanan...')
                            ->required()
                            ->searchable()
                            ->preload(),
                        TextInput::make('amount')
                            ->label('Nominal Pembayaran')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                        TextInput::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->placeholder('Contoh: Transfer BCA, QRIS, Tunai')
                            ->helperText('Metode yang digunakan pelanggan untuk membayar pesanan ini.'),
                        Select::make('status')
                            ->label('Status Transaksi')
                            ->options([
                                'pending' => 'Menunggu Pembayaran',
                                'success' => 'Berhasil / Lunas',
                                'failed' => 'Gagal / Dibatalkan',
                            ])
                            ->required()
                            ->default('pending')
                            ->helperText('Tandai sebagai Sukses jika uang sudah diterima.'),
                        FileUpload::make('payment_receipt')
                            ->label('Bukti Transfer')
                            ->image()
                            ->directory('receipts')
                            ->columnSpanFull()
                            ->helperText('Foto atau screenshot bukti pembayaran dari pelanggan.'),
                    ])->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
