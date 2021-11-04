<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{

    // public $user, $role;


    // public function mount($country)
    // {
    //     $this->country = $country;
    // }

    public function __invoke($country = "MX")
    {
        session(['country' => $country]);
        // if (auth()->user()) {

        //     $pendiente = Order::where('status', 1)->where('user_id', auth()->user()->id)->count();

        //     if ($pendiente) {

        //         $mensaje = "Usted tiene $pendiente ordenes pendientes. <a class='font-bold' href='" . route('orders.index') . "?status=1'>Ir a pagar</a>";

        //         session()->flash('flash.banner', $mensaje);
        //     }
        // }

        $categories = Category::all();

        return view('welcome', compact('categories', 'country'));
    }
}
