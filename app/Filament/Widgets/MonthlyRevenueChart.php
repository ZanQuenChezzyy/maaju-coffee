<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class MonthlyRevenueChart extends ChartWidget
{
    protected ?string $heading = 'Tren Pendapatan (6 Bulan Terakhir)';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = [];
        $months = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->translatedFormat('F'); // Nama bulan dalam bahasa lokal (Januari, Februari, dsb)
            
            $revenue = Transaction::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->where('status', 'success')
                ->sum('amount');
                
            $data[] = $revenue;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan (Rp)',
                    'data' => $data,
                    'borderColor' => '#10b981', // warna hijau emerald
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)', // transparan untuk efek area
                    'fill' => true,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
