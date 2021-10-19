<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function files(Product $product, Request $request)
    {

        // $request->validate([
        //     'file' => 'required|image|max:2048'
        // ]);

        // $url = Storage::put('products', $request->file('file'));

        // $product->images()->create([
        //     'url' => $url
        // ]);
        $file = $request->file('file');

        $extension = $file->getClientOriginalExtension();
        //$nombrearchivo  = str_slug($request->slug).".".$file->getClientOriginalExtension();
        $nombrearchivo  = session('nombre') . rand(0, 100)  . date("YmdHis") . "." . $extension;
        $file->move(public_path("images/admin/products/"), $nombrearchivo);
        $product->images()->create([
            'url' => "images/admin/products/" . $nombrearchivo
        ]);
    }
}
