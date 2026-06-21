<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithFileUploads;

class OrderTracking extends Component
{
    use WithFileUploads;

    public Order $order;
    public $receiptImage;

    public function mount(Order $order)
    {
        $this->order = $order->load(['items.menu', 'transaction', 'table']);
    }

    public function refreshOrder()
    {
        $this->order->refresh();
        $this->order->load(['items.menu', 'transaction', 'table']);
    }

    public function uploadReceipt()
    {
        $this->validate([
            'receiptImage' => 'required|image|max:5120', // 5MB Max
        ]);

        $path = $this->receiptImage->store('receipts', 'public');

        if ($this->order->transaction) {
            $this->order->transaction->update([
                'payment_receipt' => $path,
                'status' => 'success',
            ]);
        } else {
            $this->order->transaction()->create([
                'payment_method' => 'transfer',
                'status' => 'success',
                'amount' => $this->order->total_amount,
                'payment_receipt' => $path,
            ]);
        }

        $this->order->update([
            'payment_status' => 'paid',
            'status' => 'cooking',
        ]);

        $this->receiptImage = null;
        $this->order->refresh();
        session()->flash('success', 'Pembayaran berhasil dikonfirmasi! Pesanan Anda sedang diproses.');
    }

    public function render()
    {
        return view('livewire.order-tracking')->layout('components.layouts.app');
    }
}
