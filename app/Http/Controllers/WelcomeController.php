<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
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
        $countries['MX'] = 1;
        // $countries['COL'] = 2;
        // $countries['PER'] = 3;
        $countries['EC'] = 4;
        $countries['CR'] = 5;
        $countries['CL'] = 6;

        $country_id = $countries[$country];
        session(['country' => $country]);
        session(['country_id' => $country_id]);

        $categories = Category::all();

        $ofertas = Product::where('isOffer', 1)->limit(6)->get();

        return view('welcome', compact('categories', 'country', 'ofertas'));
    }
}
