<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Menu;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make([
                    Section::make('Informasi Pesanan')
                        ->description('Detail pemesanan yang dilakukan oleh pelanggan.')
                        ->icon('heroicon-o-shopping-cart')
                        ->schema([
                            Select::make('table_id')
                                ->relationship('table', 'name')
                                ->label('Nomor Meja')
                                ->placeholder('Pilih meja pelanggan...')
                                ->helperText('Pilih meja jika pelanggan makan di tempat (Dine-in). Kosongkan jika Takeaway.')
                                ->searchable()
                                ->preload(),
                            TextInput::make('total_amount')
                                ->label('Total Harga')
                                ->required()
                                ->numeric()
                                ->default(0)
                                ->prefix('Rp')
                                ->readOnly()
                                ->helperText('Otomatis dihitung dari jumlah menu yang dipesan.'),
                        ])->columns(2),
                    Section::make('Status Pesanan')
                        ->description('Pantau dan ubah status pesanan & pembayaran.')
                        ->icon('heroicon-o-arrow-path')
                        ->schema([
                            Select::make('status')
                                ->label('Status Dapur')
                                ->options([
                                    'pending' => 'Menunggu',
                                    'cooking' => 'Sedang Diproses',
                                    'ready' => 'Siap Diambil',
                                    'completed' => 'Selesai',
                                ])
                                ->required()
                                ->default('pending')
                                ->helperText('Ubah status ini seiring proses pembuatan pesanan di dapur.'),
                            Select::make('payment_status')
                                ->label('Status Pembayaran')
                                ->options([
                                    'unpaid' => 'Belum Lunas',
                                    'paid' => 'Lunas',
                                ])
                                ->required()
                                ->default('unpaid')
                                ->helperText('Pembayaran otomatis lunas jika pelanggan sudah mengunggah bukti transfer.'),
                        ])->columns(2),
                ]),

                Section::make('Daftar Menu')
                    ->description('Tambahkan menu yang dipesan ke dalam daftar ini.')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->schema([
                        Repeater::make('items')
                            ->relationship('items')
                            ->schema([
                                Select::make('menu_id')
                                    ->label('Menu')
                                    ->relationship('menu', 'name')
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                        $menu = Menu::find($state);
                                        if ($menu) {
                                            $set('price', $menu->price);
                                            $quantity = $get('quantity') ?? 1;
                                            $set('subtotal', $menu->price * $quantity);
                                        }
                                    }),
                                TextInput::make('price')
                                    ->label('Harga')
                                    ->numeric()
                                    ->required()
                                    ->readOnly()
                                    ->prefix('Rp'),
                                TextInput::make('quantity')
                                    ->label('Jumlah')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                        $price = $get('price') ?? 0;
                                        $set('subtotal', $state * $price);
                                    }),
                                TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->numeric()
                                    ->required()
                                    ->readOnly()
                                    ->prefix('Rp'),
                            ])
                            ->columns(2)
                            ->live(debounce: 500)
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                $total = 0;
                                foreach ((array) $get('items') as $item) {
                                    $price = (float) ($item['price'] ?? 0);
                                    $quantity = (int) ($item['quantity'] ?? 0);
                                    $total += ($price * $quantity);
                                }
                                $set('total_amount', $total);
                            })
                            ->addActionLabel('Tambah Menu')
                            ->columnSpanFull()
                    ]),
            ]);
    }
}
