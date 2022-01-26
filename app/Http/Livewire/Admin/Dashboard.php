<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $publishedProducts, $allProducts, $currencies_published, $currencies_all, $totalSales, $newProducts, $newUsers, $filter;
    public $money_by_country_published = array(), $money_by_country_all = array();

    public function mount()
    {
        $this->publishedProducts = Product::where('status', '2')->where('currency_id', '<>', 0)->get();
        $this->allProducts = Product::where('currency_id', '<>', 0)->get();

        $this->currencies_published = Product::where('status', '2')->where('currency_id', '<>', 0)->groupBy('currency_id')->get();
        $this->currencies_all = Product::where('currency_id', '<>', 0)->groupBy('currency_id')->get();

        foreach ($this->currencies_published as $currency) {
            $amount = Product::where('status', '2')->where('currency_id', $currency->currency_id)->sum('price');
            array_push($this->money_by_country_published, ["currency" => $currency->currency->currency, "amount" => $amount]);
        }
        foreach ($this->currencies_all as $currency) {
            $amount = Product::where('currency_id', $currency->currency_id)->sum('price');
            array_push($this->money_by_country_all, ["currency" => $currency->currency->currency, "amount" => $amount]);
        }

        $this->totalSales = Order::where('status', 4)->get();
        // $this->allProducts = Product::groupBy('currency_id')->get();
        $this->newProducts = Product::whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])->get();
        $this->newUsers = User::whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])->get();
        $this->filter = 2;
    }

    public function updatedFilter()
    {
        switch ($this->filter) {
            case '1':
                $days = 7;
                break;

            case '2':
                $days = 30;
                break;

            case '3':
                $days = 365;
                break;
        }
        $this->newProducts = Product::whereBetween('created_at', [Carbon::now()->subDays($days), Carbon::now()])->get();
        $this->newUsers = User::whereBetween('created_at', [Carbon::now()->subDays($days), Carbon::now()])->get();
        $m1 = Order::where('status', 4)->whereBetween('created_at', [Carbon::now()->subDays($days),Carbon::now()])->count();
        $m2 = Order::where('status', 4)->whereBetween('created_at', [Carbon::now()->subDays($days*2),Carbon::now()->subDays($days)])->count();
        $m3 = Order::where('status', 4)->whereBetween('created_at', [Carbon::now()->subDays($days*3),Carbon::now()->subDays($days*2)])->count();
        // $data = json_encode([$m1, $m2, $m3]);
        $data = [$m3, $m2, $m1];
        $this->emit('repaintChart',$data, $this->filter);
    }

    public function render()
    {
        return view('livewire.admin.dashboard')->layout('layouts.admin');
    }
}
