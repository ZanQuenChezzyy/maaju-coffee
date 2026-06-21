<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use App\Services\AprioriService;
use Livewire\Component;

class QrMenu extends Component
{
    public Table $table;

    public $search = '';

    public $categoryId = null;

    public $cart = [];

    public $recommendations = [];

    public $snapToken = null;
    public $activeOrders = [];

    public function mount(Table $table)
    {
        $this->table = $table;

        $activeOrderIds = session()->get('active_order_ids', []);
        $validActiveOrders = [];

        if (!empty($activeOrderIds)) {
            $orders = Order::whereIn('id', $activeOrderIds)->get();
            foreach ($orders as $order) {
                if (!in_array($order->status, ['completed', 'cancelled'])) {
                    $validActiveOrders[] = $order;
                }
            }
            $this->activeOrders = $validActiveOrders;
            session()->put('active_order_ids', collect($validActiveOrders)->pluck('id')->toArray());
        }

        $this->categories = Category::all();
        $this->menus = Menu::where('is_available', true)->get();
        // Fallback recommendations (e.g. top 3 most expensive items)
        $this->recommendations = Menu::where('is_available', true)
            ->orderBy('price', 'desc')
            ->take(3)
            ->get();
    }

    public function addToCart($menuId)
    {
        $menu = Menu::find($menuId);
        if (!$menu) {
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
        
        if (empty($this->cart)) {
            $this->showCartModal = false;
        }
        
        $this->updateRecommendations();
    }

    public function updateRecommendations()
    {
        if (empty($this->cart)) {
            $this->recommendations = Menu::where('is_available', true)
                ->orderBy('price', 'desc')
                ->take(3)
                ->get();
            return;
        }

        $apriori = new AprioriService;
        $cartIds = array_keys($this->cart);
        $recommendedIds = $apriori->getRecommendations($cartIds);

        if (empty($recommendedIds)) {
            // Fallback: Tampilkan menu lain secara acak jika belum ada rekomendasi
            $this->recommendations = Menu::where('is_available', true)
                ->whereNotIn('id', $cartIds)
                ->inRandomOrder()
                ->take(3)
                ->get();
        } else {
            $this->recommendations = Menu::whereIn('id', $recommendedIds)->get();
        }
    }

    public $showCartModal = false;
    public $showPaymentModal = false;
    public $showConfirmationModal = false;
    public $selectedPaymentMethod = null;

    public function openCartModal()
    {
        if (empty($this->cart)) {
            return;
        }
        $this->showCartModal = true;
    }

    public function closeCartModal()
    {
        $this->showCartModal = false;
    }

    public function openPaymentModal()
    {
        if (empty($this->cart)) {
            return;
        }
        $this->showCartModal = false;
        $this->showPaymentModal = true;
    }

    public function selectPaymentMethod($method)
    {
        $this->selectedPaymentMethod = $method;
        $this->showPaymentModal = false;
        $this->showConfirmationModal = true;
    }

    public function cancelCheckout()
    {
        $this->showPaymentModal = false;
        $this->showConfirmationModal = false;
        $this->selectedPaymentMethod = null;
    }

    public function confirmOrder()
    {
        if (empty($this->cart)) {
            return;
        }

        $total = collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'table_id' => $this->table->id,
            'total_amount' => $total,
            'status' => 'pending',
            'payment_status' => 'unpaid',
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
            'payment_method' => $this->selectedPaymentMethod ?? 'transfer',
            'status' => 'pending',
            'amount' => $total,
        ]);

        $this->cart = [];
        $this->recommendations = [];
        $this->cancelCheckout();

        $activeOrderIds = session()->get('active_order_ids', []);
        $activeOrderIds[] = $order->id;
        session()->put('active_order_ids', array_unique($activeOrderIds));

        return redirect()->route('order.track', ['order' => $order->id]);
    }

    public function render()
    {
        $menus = Menu::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->when($this->categoryId, fn($q) => $q->where('category_id', $this->categoryId))
            ->where('is_available', true)
            ->get();

        $categories = Category::all();

        return view('livewire.qr-menu', compact('menus', 'categories'))->layout('components.layouts.app');
    }
}
