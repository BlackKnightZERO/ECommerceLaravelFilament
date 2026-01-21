<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products')]
class ProductsPage extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.products-page', [
            'products' => Product::active()->paginate(6),
            'categories' => Category::active()->get(),
            'brands' => Brand::active()->get(),
            ]
        );
    }
}
