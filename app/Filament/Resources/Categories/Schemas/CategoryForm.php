<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kategori')
                    ->description('Tentukan nama kategori dan keterangan pendukung untuk mengelompokkan menu Anda.')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Kategori')
                            ->placeholder('Contoh: Minuman Dingin, Snack, dsb.')
                            ->helperText('Nama ini akan tampil sebagai filter kategori di halaman menu pelanggan.')
                            ->required()
                            ->maxLength(255)
                            ->autofocus(),
                        Textarea::make('description')
                            ->label('Deskripsi Kategori (Opsional)')
                            ->placeholder('Contoh: Beragam pilihan minuman segar pelepas dahaga.')
                            ->helperText('Deskripsi singkat mengenai isi kategori ini.')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
