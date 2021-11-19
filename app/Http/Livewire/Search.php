<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class Search extends Component
{

    public $search;

    public $open = false;

    public function updatedSearch($value)
    {
        if ($value) {
            $this->open = true;
        } else {
            $this->open = false;
        }
    }

    public function resetSearch(){
        $this->open = false;
        $this->search = "";
    }

    public function render()
    {

        //Tv de 32" Full HD

        if ($this->search) {
            $products = Product::join('states', 'states.id', '=', 'state_id')
                ->select('products.*', 'states.country_id')
                ->where('products.name', 'LIKE', '%' . $this->search . '%')
                ->where('status', 2)
                ->where('country_id', session('country_id'))
                ->take(8)
                ->get();
        } else {
            $products = [];
        }

        return view('livewire.search', compact('products'));
    }
}
