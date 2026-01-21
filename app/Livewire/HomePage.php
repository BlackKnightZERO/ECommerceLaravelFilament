<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Home Page')]
class HomePage extends Component
{
    public function render()
    {
        $brands = Brand::active()->get();
        $categories = Category::active()->get();
        return view('livewire.home-page', [
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }
}
