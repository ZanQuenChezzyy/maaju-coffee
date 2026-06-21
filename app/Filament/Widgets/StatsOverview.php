<?php

namespace App\Filament\Widgets;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        // 1. Pendapatan Hari Ini
        $todayRevenue = Transaction::whereDate('created_at', Carbon::today())
            ->where('status', 'success')
            ->sum('amount');

        // 2. Total Pesanan Hari Ini
        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();

        // 3. Meja Terpakai (Pesanan aktif: pending / cooking / ready, tidak completed)
        $activeTables = Order::whereNotIn('status', ['completed'])
            ->whereNotNull('table_id')
            ->distinct('table_id')
            ->count('table_id');

        // 4. Total Menu Aktif
        $activeMenus = Menu::where('is_available', true)->count();

        return [
            Stat::make('Pendapatan Hari Ini', 'Rp ' . number_format($todayRevenue, 0, ',', '.'))
                ->description('Total dari transaksi sukses')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
                
            Stat::make('Pesanan Hari Ini', $todayOrders)
                ->description('Semua pesanan masuk hari ini')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('info'),
                
            Stat::make('Meja Sedang Terpakai', $activeTables)
                ->description('Meja dengan pesanan belum selesai')
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->color('warning'),
                
            Stat::make('Menu Aktif', $activeMenus)
                ->description('Total menu yang tersedia dijual')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('primary'),
        ];
    }
}
