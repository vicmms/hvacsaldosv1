<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;

class Dashboard extends Component
{
    public $publishedProducts, $allProducts, $currencies_published, $all_sales;
    public $money_by_country_published = array(), $money_by_country_all = array();

    public function mount(){
        $this->publishedProducts = Product::where('status', '2')->where('currency_id', '<>', 0)->get();
        $this->allProducts = Product::where('currency_id', '<>', 0)->get();

        $this->currencies_published = Product::where('status', '2')->where('currency_id', '<>', 0)->groupBy('currency_id')->get();
        $this->currencies_all = Product::where('currency_id', '<>', 0)->groupBy('currency_id')->get();

        foreach ($this->currencies_published as $currency) {
            $amount = Product::where('status', '2')->where('currency_id', $currency->currency_id)->sum('price');
            array_push($this->money_by_country_published, (object)["currency" => $currency->currency->currency, "amount" => $amount]);
        }
        foreach ($this->currencies_all as $currency) {
            $amount = Product::where('currency_id', $currency->currency_id)->sum('price');
            array_push($this->money_by_country_all, (object)["currency" => $currency->currency->currency, "amount" => $amount]);
        }

        $this->all_sales = Order::where('status', 4)->get();
        // $this->allProducts = Product::groupBy('currency_id')->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard')->layout('layouts.admin');
    }
}
