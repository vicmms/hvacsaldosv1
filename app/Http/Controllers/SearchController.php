<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {

        $name = $request->name;

        $products = Product::join('states', 'states.id', '=', 'state_id')
                                ->select('products.*', 'states.country_id')
                                ->where('products.name', 'LIKE' ,'%' . $name . '%')
                                ->where('status', 2)
                                ->where('country_id', session('country_id'))
                                ->paginate(8);

        return view('search', compact('products'));
    }
}
