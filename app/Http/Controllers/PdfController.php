<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function imprimirQR(Product $product){
        $pdf = \PDF::loadView('QrPdf', compact('product'));
        // $pdf->render();
        return $pdf->stream('qr.pdf');
    }
}
