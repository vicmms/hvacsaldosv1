<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use Livewire\Component;

use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;

class EditProduct extends Component
{

    public $product, $categories, $subcategories, $brands, $slug, $shipping_cost, $city;

    public $category_id, $state_id;

    protected $rules = [
        'product.category_id' => 'required',
        'product.subcategory_id' => 'required',
        'product.name' => 'required',
        'product.model' => 'required',
        'product.serie_number' => 'required',
        'slug' => 'required|unique:products,slug',
        'product.description' => 'required',
        'product.brand_id' => 'required',
        'product.price' => 'required',
        'product.city' => 'required',
        'product.commercial_price' => 'required',
        'product.quantity' => 'numeric',
        'product.shipping' => 'required',
        'product.state_id' => 'required',
    ];

    protected $listeners = ['refreshProduct', 'delete'];

    public function mount(Product $product)
    {
        $this->product = $product;

        $this->shipping_cost = $product->shipping_cost;

        $this->categories = Category::all();

        $this->category_id = $product->category->id;

        $this->state_id = $product->state_id;

        $this->subcategories = Subcategory::all();

        $this->slug = $this->product->slug;

        $this->brands = Brand::all();
    }


    public function refreshProduct()
    {
        $this->product = $this->product->fresh();
    }

    public function updatedProductName($value)
    {
        $this->slug = Str::slug($value);
    }

    // public function updatedShippingCost($value)
    // {
    //     $this->shipping_cost = $value;
    // }

    public function updatedProductCategoryId($value)
    {
        $this->subcategories = Subcategory::all();

        $this->brands = Brand::join('brand_category', 'brands.id', 'brand_category.brand_id')
                    ->where('brand_category.category_id', $value)
                    ->orderBy('name', 'asc')
                    ->get();

        /* $this->reset(['subcategory_id', 'brand_id']); */
        $this->product->subcategory_id = "";
        $this->product->brand_id = "";
    }

    public function getSubcategoryProperty()
    {
        return Subcategory::find($this->product->subcategory_id);
    }

    public function save()
    {
        $rules = $this->rules;
        $rules['slug'] = 'required|unique:products,slug,' . $this->product->id;

        if ($this->product->subcategory_id) {
            if (!$this->subcategory->color && !$this->subcategory->size) {
                $rules['product.quantity'] = 'required|numeric';
            }
        }

        $this->validate($rules);

        $this->product->slug = $this->slug;
        $this->product->shipping_cost = $this->shipping_cost; //alternativa

        $this->product->save();

        $this->emit('saved');
    }

    public function deleteImage(Image $image)
    {
        // Storage::delete([$image->url]);
        if(file_exists($image->url)){
            unlink($image->url);
        }
        $image->delete();

        $this->product = $this->product->fresh();
    }

    public function delete()
    {

        $images = $this->product->images;

        foreach ($images as $image) {
            if(file_exists($image->url)){
                unlink($image->url);
            }
            $image->delete();
        }

        $this->product->delete();

        return redirect()->route('admin.index');
    }


    public function render()
    {
        $user = Auth::user();
        return view('livewire.admin.edit-product', compact('user'))->layout('layouts.admin');
    }
}
