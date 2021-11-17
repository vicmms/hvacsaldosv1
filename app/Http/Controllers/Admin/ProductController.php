<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function files(Product $product, Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        if(!strcasecmp($extension, 'mp4') == 0){
            if ($product->images()->count() < 4) {
                if ($extension == 'png' || $extension == 'PNG') {
                    $imagenOriginal = imagecreatefrompng($file);
                } else {
                    $imagenOriginal = imagecreatefromjpeg($file);
                }
               
                $calidad = filesize($file) < 100000 ? 80 : 35; // Valor entre 0 y 100. Mayor calidad, mayor peso
                $nombrearchivo  = rand(0, 9) . Auth::user()->id . "_" . date("YmdHis") . "." . $extension;
                $rutaImagenComprimida = public_path("images/admin/products/" . $nombrearchivo);
                $request->validate([
                    'file' => 'max:5120'
                ]);
                imagejpeg($imagenOriginal, $rutaImagenComprimida, $calidad);
    
                //$nombrearchivo  = str_slug($request->slug).".".$file->getClientOriginalExtension();
                // $file->move(public_path("images/admin/products/"), $nombrearchivo);
                $product->images()->create([
                    'url' => "images/admin/products/" . $nombrearchivo
                ]);
            }else{
                throw ValidationException::withMessages(['file' => 'No se cargaron todas las imagenes, solo se pueden subir máximo 4 imagenes por producto.']);
            }
        }else{
            if($product->videos()->count() < 1){
                $request->validate([
                    'file' => 'max:10024'
                ]);
    
                $nombrearchivo  = rand(0, 9) . Auth::user()->id . "_" . date("YmdHis") . "." . $extension;
                $file->move(public_path("videos/admin/products/"), $nombrearchivo);
        
                $product->videos()->create([
                    'url' => "videos/admin/products/" . $nombrearchivo
                ]);
            }else{
                throw ValidationException::withMessages(['file' => 'Solo se puede subir un video por producto, elimina el video actual antes de subir otro.']);
            }
        }
    }
}
