<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Country;
use App\Models\Subcategory;
use Livewire\Component;

class SubNavigation extends Component
{
    public function render()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $tlds = Country::all();
        return view('livewire.sub-navigation', compact('categories', 'subcategories', 'tlds'));
    }
}
