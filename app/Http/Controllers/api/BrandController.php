<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function getBrands(Request $request){
        $brands = Brand::all();
        
        if($request->input('category_id')){
            $brands = Brand::join('brand_category', 'brands.id', 'brand_category.brand_id')
            ->select('brands.*')
            ->where('brand_category.category_id', $request->input('category_id'))
            ->orderBy('name', 'asc')
            ->get();
        }

        return $brands;
    }
}
