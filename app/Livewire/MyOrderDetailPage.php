<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Order Detail Page')]
class MyOrderDetailPage extends Component
{
    public $order;

    public function mount(Order $order)
    {
        $order->load('address');
        $order->load('items');
        $this->order = $order;
    }

    public function render()
    {
        return view('livewire.my-order-detail-page');
    }
}
