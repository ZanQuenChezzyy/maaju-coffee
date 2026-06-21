<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class OrdersByCategoryChart extends ChartWidget
{
    protected ?string $heading = 'Pesanan per Kategori (Porsi)';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $categories = DB::table('categories')
            ->select('categories.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->leftJoin('menus', 'categories.id', '=', 'menus.category_id')
            ->leftJoin('order_items', 'menus.id', '=', 'order_items.menu_id')
            ->groupBy('categories.id', 'categories.name')
            ->having('total_sold', '>', 0)
            ->get();

        $labels = [];
        $data = [];

        foreach ($categories as $category) {
            $labels[] = $category->name;
            $data[] = $category->total_sold;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Porsi Terjual',
                    'data' => $data,
                    'backgroundColor' => [
                        '#3b82f6', // blue
                        '#10b981', // emerald
                        '#f59e0b', // amber
                        '#ef4444', // red
                        '#8b5cf6', // violet
                        '#ec4899', // pink
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
