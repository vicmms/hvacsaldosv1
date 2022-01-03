<?php

namespace App\Http\Livewire;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartMobil extends Component
{
    protected $listeners = ['render'];
    
    public function render()
    {
        $cart_count = Cart::count();
        return view('livewire.cart-mobil', compact('cart_count'));
    }
}
