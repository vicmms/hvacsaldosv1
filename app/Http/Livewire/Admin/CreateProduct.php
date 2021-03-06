<?php

namespace App\Http\Livewire\Admin;

use App\Mail\NewProductMailable;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

use Illuminate\Support\Str;

class CreateProduct extends Component
{

    public $categories, $subcategories = [], $brands = [], $currencies = [], $envios = [];
    public $category_id = "", $subcategory_id = "", $brand_id = "", $state_id = "", $user_id, $currency_id = "";
    public $name, $slug, $description, $price, $quantity, $commercial_price, $model, $serie_number, $shipping, $unit, $city;

    protected $rules = [
        'category_id' => 'required',
        'subcategory_id' => 'required',
        'currency_id' => 'required',
        'state_id' => 'required',
        'name' => 'required',
        'slug' => 'required|unique:products',
        'description' => 'required',
        'brand_id' => 'required',
        'price' => 'required',
        'commercial_price' => 'required',
        'unit' => 'required',
        'city' => 'required',
        'quantity' => 'required',
        'model' => 'required',
        'envios' => 'required',
        'state_id' => 'required'
    ];

    public function mount()
    {
        $this->categories = Category::all();
        $this->user_id = Auth::user()->id;
        $this->currencies = Currency::where('id', Auth::user()->country->currency_id)->orWhere('id', 2)->get(); //2 = USD
        $this->envios = ["1"];
        $this->state_id = Auth::user()->state_id ? Auth::user()->state_id : null;
    }

    public function updatedCategoryId($value)
    {
        // $this->subcategories = Subcategory::where('category_id', $value)->get();
        $this->subcategories = Subcategory::all();

        // $this->brands = Brand::whereHas('categories', function (Builder $query) use ($value) {
        //     $query->where('category_id', $value);
        // })->get();
        $this->brands = Brand::join('brand_category', 'brands.id', 'brand_category.brand_id')
                    ->select('brands.*')
                    ->where('brand_category.category_id', $value)
                    ->orderBy('name', 'asc')
                    ->get();

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

    public function save()
    {

        $rules = $this->rules;

        $this->validate($rules);

        $product = new Product();

        $product->name = $this->name;
        $product->slug = $this->slug . " " . rand(10,99) . Auth::user()->id;
        $product->description = $this->description;
        $product->price = str_replace(',','', $this->price);
        $product->commercial_price = str_replace(',','', $this->commercial_price);
        $product->model = $this->model;
        $product->shipping = json_encode($this->envios);
        $product->serie_number = $this->serie_number;
        $product->subcategory_id = $this->subcategory_id;
        $product->category_id = $this->category_id;
        $product->brand_id = $this->brand_id;
        $product->state_id = $this->state_id;
        $product->user_id = $this->user_id;
        $product->city = $this->city;
        $product->quantity = $this->quantity;
        $product->unit = $this->unit;
        $product->currency_id = $this->currency_id;
        $product->status = 4;

        $product->save();

        // $mail = new NewProductMailable($this->user);
        // $emails = array("administracion@saldohvac.com");
        // Mail::to($emails)->send($mail);

        return redirect()->route('admin.products.edit', $product);
    }

    public function render()
    {
        $user = Auth::user();
        // $this->brands = Brand::join('brand_category', 'brands.id', 'brand_category.brand_id')
        //             ->select('brands.*')
        //             ->where('brand_category.category_id', $this->category_id)
        //             ->orderBy('name', 'asc')
        //             ->get();
        return view('livewire.admin.create-product', compact('user'))->layout('layouts.admin');
    }
}
