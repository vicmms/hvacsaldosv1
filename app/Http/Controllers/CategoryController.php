<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\User;

class CategoryController extends Controller
{
    public function show(Category $category, $country = "MX")
    {
        $seller = null;
        return view('categories.show', compact('category', 'country', 'seller'));
    }

    public function showAll($country = "MX")
    {
        $category = 'all';
        $seller = null;
        return view('categories.show', compact('category', 'country', 'seller'));
    }

    public function offers($country = "MX")
    {
        $category = 'offers';
        $seller = null;
        return view('categories.show', compact('category', 'country', 'seller'));
    }

    public function getProductsBySeller(User $seller, $country = "MX")
    {
        $category = 'bySeller';
        return view('categories.show', compact('category', 'seller', 'country'));
    }
}
