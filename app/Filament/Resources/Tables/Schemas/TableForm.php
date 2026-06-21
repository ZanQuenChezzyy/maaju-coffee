<?php

namespace App\Filament\Resources\Tables\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TableForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Meja')
                    ->description('Kelola nama meja dan tautan QR Code-nya.')
                    ->icon('heroicon-o-squares-2x2')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nomor / Nama Meja')
                            ->placeholder('Contoh: Meja 1, VIP A, Teras 2')
                            ->helperText('Penamaan meja yang akan digunakan pelanggan untuk memesan.')
                            ->required()
                            ->maxLength(255)
                            ->autofocus(),
                        TextInput::make('qr_code_url')
                            ->label('Tautan (Opsional)')
                            ->url()
                            ->placeholder('Contoh: https://maajucoffee.com/menu?table=1')
                            ->helperText('Tautan ini otomatis digenerate atau dapat diisi manual jika menggunakan sistem eksternal.'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
