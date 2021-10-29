<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use Illuminate\Support\Str;

class CreateProduct extends Component
{

    public $categories, $subcategories = [], $brands = [];
    public $category_id = "", $subcategory_id = "", $brand_id = "", $state_id = "", $user_id;
    public $name, $slug, $description, $price, $quantity, $commercial_price, $model, $serie_number, $shipping, $shipping_cost, $city;

    protected $rules = [
        'category_id' => 'required',
        'subcategory_id' => 'required',
        'state_id' => 'required',
        'name' => 'required',
        'slug' => 'required|unique:products',
        'description' => 'required',
        'brand_id' => 'required',
        'price' => 'required',
        'commercial_price' => 'required',
        'serie_number' => 'required',
        'city' => 'required',
        'model' => 'required',
        'shipping' => 'required',
        'shipping_cost' => 'required',
        'state_id' => 'required'
    ];

    public function updatedCategoryId($value)
    {
        // $this->subcategories = Subcategory::where('category_id', $value)->get();
        $this->subcategories = Subcategory::all();

        // $this->brands = Brand::whereHas('categories', function (Builder $query) use ($value) {
        //     $query->where('category_id', $value);
        // })->get();
        $this->brands = Brand::orderBy('name', 'asc')->get();

        $this->reset(['subcategory_id', 'brand_id']);
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function getSubcategoryProperty()
    {
        return Subcategory::find($this->subcategory_id);
    }

    public function mount()
    {
        $this->categories = Category::all();
        $this->user_id = Auth::user()->id;
        $this->shipping = 0;
    }


    public function save()
    {

        $rules = $this->rules;

        if ($this->subcategory_id) {
            if (!$this->subcategory->color && !$this->subcategory->size) {
                $rules['quantity'] = 'required';
            }
        }

        // $this->validate($rules);

        $product = new Product();

        $product->name = $this->name;
        $product->slug = $this->slug;
        $product->description = $this->description;
        $product->price = $this->price;
        $product->commercial_price = $this->commercial_price;
        $product->model = $this->model;
        $product->shipping = $this->shipping;
        $product->shipping_cost = $this->shipping_cost;
        $product->serie_number = $this->serie_number;
        $product->subcategory_id = $this->subcategory_id;
        $product->category_id = $this->category_id;
        $product->brand_id = $this->brand_id;
        $product->state_id = $this->state_id;
        $product->user_id = $this->user_id;
        $product->city = $this->city;
        $product->quantity = $this->quantity;

        $product->save();

        return redirect()->route('admin.products.edit', $product);
    }

    public function render()
    {
        $user = Auth::user();
        return view('livewire.admin.create-product', compact('user'))->layout('layouts.admin');
    }
}
