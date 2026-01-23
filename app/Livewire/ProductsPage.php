<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products')]
class ProductsPage extends Component
{
    use WithPagination;

    #[Url]
    public $selected_categories = [];
    
    #[Url]
    public $selected_brands = [];

    #[Url]
    public $is_featured;
    
    #[Url]
    public $on_sale;

    #[Url]
    public $price = 300000;

    #[Url]
    public $sort = 'latest';

    //add product to cart
    public function addToCart($product_id) {
        $total_count = CartManagement::addItemToCart($product_id);
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
        $query = Product::active();
        if(!empty($this->selected_categories)) {
            $query->whereIn('category_id', $this->selected_categories);
        }
        if(!empty($this->selected_brands)) {
            $query->whereIn('brand_id', $this->selected_brands);
        }
        if($this->is_featured) {
            $query->where('is_featured', 1);
        }
        if($this->on_sale) {
            $query->where('on_sale', 1);
        }
        if($this->price) {
            // $query->where('price','<', $this->price);
            $query->whereBetween('price', [0, $this->price]);
        }
        if($this->sort == 'latest') {
            $query->latest();
        }
        if($this->sort == 'price') {
            $query->orderBy('price', 'asc');
        }
        return view('livewire.products-page', [
            'products' => $query->paginate(9),
            'categories' => Category::active()->get(),
            'brands' => Brand::active()->get(),
            ]
        );
    }
}
