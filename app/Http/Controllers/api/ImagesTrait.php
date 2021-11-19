<?php

use App\Models\Product;
use Illuminate\Http\Request;

trait setImages{

    public function files(Product $product, Request $request){

        // $request->validate([
        //     'file' => 'required|max:2048'
        // ]);

        // $url = Storage::put('public/products', $request->file('file'));

        // $product->images()->create([
        //     'url' => $url
        // ]);
        return json_encode("kjnbijh");
    }
    }