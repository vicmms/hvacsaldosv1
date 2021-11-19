<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Category;
use App\Models\Country;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class Navigation extends Component
{
    public $url, $country, $categories, $subcategories, $tlds;

    public function mount()
    {
        $this->url =  url()->current();
        $this->url = explode(".", $this->url);
        $this->url = explode("/", $this->url[count($this->url) - 1]);

        $this->country = (count($this->url) > 1 && strlen($this->url[count($this->url) - 1]) < 3) ? $this->url[count($this->url) - 1] : 'MX';
        $this->categories = Category::all();
        $this->subcategories = Subcategory::all();
        $this->tlds = Country::all();
    }

    public function render()
    {

        $categories = $this->categories;
        $subcategories = $this->subcategories;
        $country = $this->country;
        $tlds = $this->tlds;
        return view('livewire.navigation', compact('tlds', 'categories', 'subcategories', 'country'));
    }
}
