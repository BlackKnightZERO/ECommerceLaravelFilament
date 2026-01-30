<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Checkout Page')]
class CheckoutPage extends Component
{
    #[Validate('required')]
    public $first_name;
     #[Validate('required')]
    public $last_name;
     #[Validate('required')]
    public $phone;
     #[Validate('required')]
    public $street_address;
     #[Validate('required')]
    public $city;
     #[Validate('required')]
    public $state;
     #[Validate('required')]
    public $zip_code;
     #[Validate('required')]
    public $payment_method = "cod";

    public function mount() {
        $cart_items = CartManagement::getCartItemsFromCookie();
        if(count($cart_items) == 0) {
            return redirect('/products');
        }
    }

    public function placeOrder() {
        $this->validate();

        $cart_items = CartManagement::getCartItemsFromCookie();
        $grand_total = CartManagement::calculateGrandTotal($cart_items);

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->grand_total = $grand_total;
        $order->payment_method = $this->payment_method;
        $order->payment_status = ($this->payment_method == 'cod') ? 'pending' : 'paid';
        $order->status = 'new';
        $order->currency = 'BDT';
        $order->shipping_amount = 0.00;
        $order->shipping_method = 'steadfast';
        $order->notes = 'Order placed by '. Auth::user()->name;
        $order->save();

        $address = new Address();
        $address->order_id = $order->id;
        $address->first_name = $this->first_name;
        $address->last_name = $this->last_name;
        $address->phone = $this->phone;
        $address->street_address = $this->street_address;
        $address->city = $this->city;
        $address->state = $this->state;
        $address->zip_code = $this->zip_code;
        $address->save();

        foreach($cart_items as $item) {
            $order_item = new OrderItem();
            $order_item->order_id = $order->id;
            $order_item->product_id = $item['product_id'];
            $order_item->quantity = $item['quantity'];  
            $order_item->unit_amount = $item['unit_amount'];
            $order_item->total_amount = $item['total_amount'];
            $order_item->save();

            // CartManagement::removeItemFromCart($item['product_id']);
        }
        CartManagement::clearCartItems();
        return redirect('/success');
    }

    public function render()
    {
        $cart_items = CartManagement::getCartItemsFromCookie();
        $grand_total = CartManagement::calculateGrandTotal($cart_items);
        return view('livewire.checkout-page', [
            'cart_items' => $cart_items,
            'grand_total' => $grand_total,
        ]);
    }
}
