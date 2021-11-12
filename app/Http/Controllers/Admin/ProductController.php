<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function files(Product $product, Request $request)
    {
        $file = $request->file('file');

        $extension = $file->getClientOriginalExtension();
        if($extension == 'png' || $extension == 'PNG'){
            $imagenOriginal = imagecreatefrompng($file);
        }else{
            $imagenOriginal = imagecreatefromjpeg($file);
        }

        $calidad = 20; // Valor entre 0 y 100. Mayor calidad, mayor peso
        $nombrearchivo  = rand(0, 9) . Auth::user()->id . "_" . date("YmdHis") . "." . $extension;
        $rutaImagenComprimida = public_path("images/admin/products/".$nombrearchivo);
        imagejpeg($imagenOriginal, $rutaImagenComprimida, $calidad);

        //$nombrearchivo  = str_slug($request->slug).".".$file->getClientOriginalExtension();
        // $file->move(public_path("images/admin/products/"), $nombrearchivo);
        $product->images()->create([
            'url' => "images/admin/products/" . $nombrearchivo
        ]);
    }

}
