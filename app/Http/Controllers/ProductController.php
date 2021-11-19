<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Question;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $questions = Question::with('answer')->where('product_id', $product->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('products.show', compact('product', 'questions'));
    }
}
