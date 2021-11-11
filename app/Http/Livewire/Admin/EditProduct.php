<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Currency;
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

    public $product, $categories, $subcategories, $brands, $slug, $currencies, $city, $isRejected, $modalImages;

    public $category_id, $state_id, $firstTime;

    protected $rules = [
        'product.category_id' => 'required',
        'product.subcategory_id' => 'required',
        'product.name' => 'required',
        'product.model' => 'required',
        'slug' => 'required|unique:products,slug',
        'product.description' => 'required',
        'product.brand_id' => 'required',
        'product.price' => 'required',
        'product.city' => 'required',
        'product.commercial_price' => 'required',
        'product.quantity' => 'numeric',
        'product.shipping' => 'required',
        'product.state_id' => 'required',
        'product.unit' => 'required',
        'product.currency_id' => 'required',
        'product.quantity' => 'required',
    ];

    protected $listeners = ['refreshProduct', 'delete'];

    public function mount(Product $product)
    {
        $this->product = $product;

        $this->isRejected = $this->product->status == 3 ? true : false;

        $this->currencies = Currency::all();

        $this->categories = Category::all();

        $this->category_id = $product->category->id;

        $this->state_id = $product->state_id;

        $this->subcategories = Subcategory::all();

        $this->slug = $this->product->slug;

        $this->brands = Brand::all();

        $this->modalImages = false;

        $this->firstTime = true;
    }


    public function refreshProduct()
    {
        $this->product = $this->product->fresh();
    }

    public function updatedProductName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function updatedProductCategoryId($value)
    {
        $this->subcategories = Subcategory::all();

        $this->brands = Brand::join('brand_category', 'brands.id', 'brand_category.brand_id')
            ->select('brands.*')
            ->where('brand_category.category_id', $this->category_id)
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

    public function save($revision = false)
    {
        if ($revision)
            $this->product->status = 1;

        $rules = $this->rules;
        $rules['slug'] = 'required|unique:products,slug,' . $this->product->id;

        $this->validate($rules);

        $this->product->slug = $this->slug;

        $this->product->price = str_replace(',', '', $this->product->price);

        $this->product->commercial_price = str_replace(',', '', $this->product->commercial_price);

        $this->product->save();

        $this->emit('saved');

        return redirect()->route('admin.index');
    }

    public function deleteImage(Image $image)
    {
        // Storage::delete([$image->url]);
        if (file_exists($image->url)) {
            unlink($image->url);
        }
        $image->delete();

        $this->product = $this->product->fresh();
    }

    public function delete()
    {

        $images = $this->product->images;

        foreach ($images as $image) {
            if (file_exists($image->url)) {
                unlink($image->url);
            }
            $image->delete();
        }

        $this->product->delete();

        return redirect()->route('admin.index');
    }

    public function modalImages()
    {
        $this->modalImages = !$this->modalImages;

        if($this->modalImages){
            $this->emit('showModalImages', $this->product->images);
        }
    }


    public function render()
    {
        $user = Auth::user();
        $this->brands = Brand::join('brand_category', 'brands.id', 'brand_category.brand_id')
            ->select('brands.*')
            ->where('brand_category.category_id', $this->category_id)
            ->orderBy('name', 'asc')
            ->get();
        return view('livewire.admin.edit-product', compact('user'))->layout('layouts.admin');
    }
}
