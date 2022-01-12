<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CategoryProducts extends Component
{

    public $category;

    public $country;

    public $products = [];

    // public $countries;

    public function mount()
    {


        // $this->$country_id = 1;
    }

    public function loadPosts()
    {
        $countries['MX'] = 1;
        $countries['COL'] = 2;
        $countries['PER'] = 3;
        $countries['EC'] = 4;
        $countries['CR'] = 5;
        $countries['CL'] = 6;

        $country_id = array_key_exists($this->country, $countries)  ? $countries[$this->country] : 'MX';

        // if (Auth::user()) {
        //     // $role = $user->getRoleNames()->first();
        //     $this->products = $this->category->products()
        //         ->join('states', 'states.id', '=', 'state_id')
        //         ->select('products.*', 'states.country_id')
        //         ->where('country_id', $country_id)
        //         ->where('status', 2)
        //         ->take(15)->get();
        // } else {
        $this->products = $this->category->products()
            ->join('states', 'states.id', '=', 'state_id')
            ->select('products.*', 'states.country_id')
            ->where('status', 2)
            ->where('quantity', '>', 0)
            ->where('country_id', $country_id)
            ->take(15)->get();
        // }

        $this->emit('glider', $this->category->id);
    }

    public function render()
    {
        return view('livewire.category-products');
    }
}
