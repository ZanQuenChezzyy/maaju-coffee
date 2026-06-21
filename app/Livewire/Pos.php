<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\AprioriService;
use Livewire\Component;

class Pos extends Component
{
    public $search = '';

    public $categoryId = null;

    public $cart = [];

    public $recommendations = [];

    public $paymentMethod = 'cash';

    public function addToCart($menuId)
    {
        $menu = Menu::find($menuId);
        if (! $menu) {
            return;
        }

        if (isset($this->cart[$menuId])) {
            $this->cart[$menuId]['quantity']++;
        } else {
            $this->cart[$menuId] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'quantity' => 1,
            ];
        }
        $this->updateRecommendations();
    }

    public function removeFromCart($menuId)
    {
        if (isset($this->cart[$menuId])) {
            $this->cart[$menuId]['quantity']--;
            if ($this->cart[$menuId]['quantity'] <= 0) {
                unset($this->cart[$menuId]);
            }
        }
        $this->updateRecommendations();
    }

    public function updateRecommendations()
    {
        $apriori = new AprioriService;
        $cartIds = array_keys($this->cart);
        $recommendedIds = $apriori->getRecommendations($cartIds);
        $this->recommendations = Menu::whereIn('id', $recommendedIds)->get();
    }

    public function checkout()
    {
        if (empty($this->cart)) {
            return;
        }

        $total = collect($this->cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'total_amount' => $total,
            'status' => 'completed',
            'payment_status' => 'paid',
        ]);

        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        $order->transaction()->create([
            'payment_method' => $this->paymentMethod,
            'status' => 'success',
            'amount' => $total,
        ]);

        $this->cart = [];
        $this->recommendations = [];
        $this->paymentMethod = 'cash';
        
        session()->flash('success', 'Pesanan berhasil diproses dan Lunas!');
    }

    public function render()
    {
        $menus = Menu::query()
            ->when($this->search, fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->when($this->categoryId, fn ($q) => $q->where('category_id', $this->categoryId))
            ->where('is_available', true)
            ->get();

        $categories = Category::all();

        return view('livewire.pos', compact('menus', 'categories'))->layout('components.layouts.app');
    }
}
