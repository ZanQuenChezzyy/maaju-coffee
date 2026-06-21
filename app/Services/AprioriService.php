<?php

namespace App\Services;

use App\Models\Order;

class AprioriService
{
    protected float $minSupport;

    protected float $minConfidence;

    public function __construct(float $minSupport = 0.1, float $minConfidence = 0.5)
    {
        $this->minSupport = $minSupport;
        $this->minConfidence = $minConfidence;
    }

    /**
     * Get recommendations based on current cart items.
     *
     * @return array Array of recommended menu_ids sorted by confidence
     */
    public function getRecommendations(array $cartMenuIds): array
    {
        if (empty($cartMenuIds)) {
            return [];
        }

        $transactions = $this->getTransactions();
        $totalTransactions = count($transactions);

        if ($totalTransactions === 0) {
            return [];
        }

        $itemCounts = [];
        $pairCounts = [];

        // Count occurrences
        foreach ($transactions as $transaction) {
            $items = array_unique($transaction);
            sort($items);

            foreach ($items as $item) {
                if (! isset($itemCounts[$item])) {
                    $itemCounts[$item] = 0;
                }
                $itemCounts[$item]++;
            }

            // Count pairs
            for ($i = 0; $i < count($items); $i++) {
                for ($j = $i + 1; $j < count($items); $j++) {
                    $pair = $items[$i].','.$items[$j];
                    if (! isset($pairCounts[$pair])) {
                        $pairCounts[$pair] = 0;
                    }
                    $pairCounts[$pair]++;
                }
            }
        }

        $rules = [];

        // Generate rules A => B
        foreach ($pairCounts as $pair => $count) {
            $supportPair = $count / $totalTransactions;

            if ($supportPair >= $this->minSupport) {
                [$item1, $item2] = explode(',', $pair);

                // Rule item1 => item2
                $supportItem1 = $itemCounts[$item1] / $totalTransactions;
                $confidence1 = $supportPair / $supportItem1;
                if ($confidence1 >= $this->minConfidence) {
                    $rules[] = [
                        'from' => $item1,
                        'to' => $item2,
                        'confidence' => $confidence1,
                    ];
                }

                // Rule item2 => item1
                $supportItem2 = $itemCounts[$item2] / $totalTransactions;
                $confidence2 = $supportPair / $supportItem2;
                if ($confidence2 >= $this->minConfidence) {
                    $rules[] = [
                        'from' => $item2,
                        'to' => $item1,
                        'confidence' => $confidence2,
                    ];
                }
            }
        }

        $recommendations = [];

        foreach ($cartMenuIds as $cartItem) {
            foreach ($rules as $rule) {
                if ($rule['from'] == $cartItem && ! in_array($rule['to'], $cartMenuIds)) {
                    if (! isset($recommendations[$rule['to']]) || $recommendations[$rule['to']] < $rule['confidence']) {
                        $recommendations[$rule['to']] = $rule['confidence'];
                    }
                }
            }
        }

        arsort($recommendations);

        return array_keys($recommendations);
    }

    /**
     * Retrieve all completed transactions as array of menu_ids.
     */
    protected function getTransactions(): array
    {
        return Order::where('status', 'completed')
            ->with('items')
            ->get()
            ->map(function ($order) {
                return $order->items->pluck('menu_id')->toArray();
            })
            ->toArray();
    }
}
