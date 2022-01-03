<?php

namespace App\Http\Livewire;

use App\Models\Currency;
use Livewire\Component;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Storage;

class AddCartItem extends Component
{
    public $product, $quantity;
    public $qty = 1;
    public $options = [
        'color_id' => null,
        'size_id' => null
    ];

    public function mount()
    {
        $this->quantity = qty_available($this->product->id);
        $this->options['image'] = count($this->product->images) ? $this->product->images->first()->url : "images/image-not-found.jpg";
    }

    public function decrement()
    {
        $this->qty = $this->qty - 1;
    }

    public function increment()
    {
        $this->qty = $this->qty + 1;
    }

    public function addItem()
    {
        $currency = Currency::where('id', $this->product->currency_id)->first();
        $currency = $currency ? $currency->currency . " " . $currency->symbol : '$';
        $this->options['currency'] = $currency;
        $this->options['slug'] = $this->product->slug;
        $this->options['user_id'] = $this->product->user_id;
        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => $this->qty,
            'price' => $this->product->price,
            'weight' => 550,
            'options' => $this->options,

        ]);

        $this->quantity = qty_available($this->product->id);

        $this->reset('qty');

        $this->emitTo('dropdown-cart', 'render');
        $this->emitTo('cart-mobil', 'render');
    }

    public function render()
    {
        return view('livewire.add-cart-item');
    }
}
