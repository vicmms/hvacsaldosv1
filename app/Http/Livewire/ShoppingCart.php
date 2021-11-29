<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Str;

class ShoppingCart extends Component
{

    protected $listeners = ['render'];

    public function destroy()
    {
        Cart::destroy();

        $this->emitTo('dropdown-cart', 'render');
    }

    public function delete($rowID)
    {
        Cart::remove($rowID);
        $this->emitTo('dropdown-cart', 'render');
    }

    public function render()
    {
        $currencies = array();
        $totales = [];
        foreach (Cart::content() as $item) {
            array_search($item->options->currency, $currencies) ? null : array_push($currencies, $item->options->currency);
            $totales[$item->options->currency] = array('currency' => $item->options->currency, 'price' => []);
        }
        foreach (Cart::content() as $item) {
            array_push($totales[$item->options->currency]['price'],  $item->price);
        }
        return view('livewire.shopping-cart', compact('totales'));
    }
}
