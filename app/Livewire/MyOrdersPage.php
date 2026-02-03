<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Orders Page')]
class MyOrdersPage extends Component
{
    public function render()
    {
        $my_orders = Order::where('user_id', auth()->user()->id)->latest()->get();
        return view('livewire.my-orders-page', [
            'my_orders' => $my_orders
        ]);
    }
}
