<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cart')]
class CartPage extends Component
{
    public $cart_items;
    public $grand_total;

    public function mount() {
        $this->cart_items = CartManagement::getCartItemsFromCookie();
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
    }

    public function removeItem($product_id) {
        $this->cart_items = CartManagement::removeItemFromCart($product_id);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
        $this->dispatch('update-cart-count', total_count: count($this->cart_items))->to(Navbar::class);
        LivewireAlert::title('Product removed from the cart successfully!')
            ->success()
            ->position('bottom-end')
            ->timer(3000)
            ->toast()
            ->show();
    }

    public function decreaseQty($product_id) {
        $this->cart_items = CartManagement::decrementItemQuantity($product_id);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
        $this->dispatch('update-cart-count', total_count: count($this->cart_items))->to(Navbar::class);
        LivewireAlert::title('Product count updated successfully!')
            ->success()
            ->position('bottom-end')
            ->timer(3000)
            ->toast()
            ->show();
    }

    public function increaseQty($product_id) {
        $this->cart_items = CartManagement::incrementItemQuantity($product_id);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
        $this->dispatch('update-cart-count', total_count: count($this->cart_items))->to(Navbar::class);
        LivewireAlert::title('Product count updated successfully!')
            ->success()
            ->position('bottom-end')
            ->timer(3000)
            ->toast()
            ->show();
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}
