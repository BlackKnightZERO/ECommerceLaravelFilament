<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Product Detail')]
class ProductDetailPage extends Component
{
    public $slug;

    public $quantity = 1;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function increaseQty()
    {
        $this->quantity++;
    }

    public function decreaseQty()
    {
        if($this->quantity > 1) {
            $this->quantity--;
        }
    }


    public function addToCart($product_id, $quantity) {
        $total_count = CartManagement::addItemToCart($product_id, $quantity);
        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);
        LivewireAlert::title('Product added to the cart successfully!')
            ->success()
            ->position('bottom-end')
            ->timer(3000)
            ->toast()
            ->show();
    }

    public function render()
    {
        return view('livewire.product-detail-page', [
            'product' => Product::where('slug', $this->slug)->firstOrFail()
        ]);
    }
}
