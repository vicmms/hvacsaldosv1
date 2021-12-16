<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category, $country = "MX")
    {
        return view('categories.show', compact('category', 'country'));
    }

    public function showAll($country = "MX")
    {
        $category = 'all';
        return view('categories.show', compact('category', 'country'));
    }

    public function offers($country = "MX")
    {
        $category = 'offers';
        return view('categories.show', compact('category', 'country'));
    }
}
