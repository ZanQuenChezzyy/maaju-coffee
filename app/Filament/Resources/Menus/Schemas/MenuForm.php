<?php

namespace App\Filament\Resources\Menus\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Menu')
                    ->description('Lengkapi detail menu makanan atau minuman yang akan dijual.')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->schema([
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->label('Kategori')
                            ->placeholder('Pilih kategori...')
                            ->helperText('Pilih kategori yang sesuai untuk menu ini.')
                            ->required()
                            ->searchable()
                            ->preload(),
                        TextInput::make('name')
                            ->label('Nama Menu')
                            ->placeholder('Contoh: Kopi Susu Gula Aren')
                            ->helperText('Nama menu yang akan dilihat oleh pelanggan.')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('price')
                            ->label('Harga')
                            ->placeholder('Contoh: 15000')
                            ->helperText('Masukkan harga dalam format angka tanpa titik/koma.')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                        Toggle::make('is_available')
                            ->inline(false)
                            ->label('Tersedia')
                            ->default(true)
                            ->helperText('Matikan jika menu ini sedang kosong atau habis.')
                            ->required(),
                        Textarea::make('description')
                            ->label('Deskripsi (Opsional)')
                            ->placeholder('Contoh: Kopi susu manis dengan gula aren asli yang menyegarkan.')
                            ->helperText('Penjelasan singkat tentang rasa atau isi menu ini.')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Ketersediaan & Gambar')
                    ->description('Atur gambar menu dan status ketersediaannya.')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Foto Menu')
                            ->image()
                            ->directory('menus')
                            ->helperText('Pilih foto beresolusi baik agar terlihat menarik di menu pelanggan.'),
                    ])
                    ->columns(1),
            ]);
    }
}
