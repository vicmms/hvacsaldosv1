<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Image;
use App\Models\Notification;
use Livewire\Component;

use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;

class EditProduct extends Component
{

    public $product, $categories, $brand_id = "", $subcategories, $brands, $slug, $currencies, $city, $isRejected, $isNew, $modalImages, $serie_number;

    public $category_id, $state_id, $firstTime, $currency_id;

    protected $rules = [
        'product.category_id' => 'required',
        'product.subcategory_id' => 'required',
        'product.name' => 'required',
        'product.model' => 'required',
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
        $product->currency_id == 0 ? $product->currency_id = "" : false;

        $this->product = $product;

        $this->isRejected = $this->product->status == 3 ? true : false;

        $this->isNew = $this->product->status == 4 ? true : false;

        $this->currencies = Currency::where('id', Auth::user()->country->currency_id)->orWhere('id', 2)->get(); //2 = USD

        $this->categories = Category::all();

        $this->category_id = $product->category->id;

        $this->state_id = $product->state_id;

        $this->subcategories = Subcategory::all();

        $this->brands = Brand::whereHas('categories', function(Builder $query){
            $query->where('category_id', $this->category_id);
        })->get();

        $this->modalImages = false;

        $this->firstTime = true;

        $this->serie_number = $product->serie_number;
    }


    public function refreshProduct($isMaxImages = false)
    {
        // $contImages = $this->product->images()->count();
        
        $this->product->images = $this->product->images->fresh();
    }

    public function updatedProductCategoryId($value)
    {
        $this->subcategories = Subcategory::all();

        $this->brands = Brand::join('brand_category', 'brands.id', 'brand_category.brand_id')
            ->select('brands.*')
            ->where('brand_category.category_id', $value)
            ->orderBy('name', 'asc')
            ->get();
        $this->reset(['brand_id']);
    }

    public function getSubcategoryProperty()
    {
        return Subcategory::find($this->product->subcategory_id);
    }

    public function save($revision = false)
    {
        $rules = $this->rules;
        $this->validate($rules);

        if ($revision) {
            $company_info = DB::table('companies')->where('user_id', Auth::user()->id)->first();
            if ($this->product->images()->count()) {
                if ($company_info) {
                    if (strlen($company_info->name) > 2 && strlen($company_info->tax_data) > 10) {
                        $notification = 'El producto "' . $this->product->name . '" se ha mandado a revisión, te avisaremos por este medio y correo electrónico cuando sea validado.';
                        $user_id = Auth::user()->id;
                        $product_id = $this->product->id;
                        $this->createNotification($notification, $user_id, $product_id, false);

                        $notification = 'Se ha solicitado la revisión de un nuevo producto. <a class="block underline text-blue-900" href="/admin?status=1">Ver solicitudes</a>';
                        $users = User::whereHas(
                            'roles',
                            function ($q) {
                                $q->where('name', 'admin')->orWhere('name', 'user');
                            }
                        )
                            ->where('country_id', Auth::user()->country_id)
                            ->get();
                        foreach ($users as $user) {
                            $this->createNotification($notification, $user->id, $product_id, true);
                        }
                        $this->product->status = 1;
                    } else {
                        $this->emit('company_info');
                        return false;
                    }
                } else {
                    $this->emit('company_info');
                    return false;
                }
            } else {
                $this->emit('images');
                return false;
            }
        }

        $this->product->slug = Str::slug($this->product->name) . " " . $this->product->id . Auth::user()->id;
        $this->product->price = str_replace(',', '', $this->product->price);
        $this->product->commercial_price = str_replace(',', '', $this->product->commercial_price);
        $this->product->serie_number = $this->serie_number;

        $this->product->save();

        $this->emit('saved');

        event(new \App\Events\NavNotification());
        $current_page = session('page') ? session('page') : 1;
        if (!count(Auth::user()->getRoleNames())) {
            return redirect()->route('admin.index', ['page' => $current_page]);
        }
    }

    public function createNotification($notification, $user_id, $product_id, $isAdmin)
    {
        Notification::create([
            'notification' => $notification,
            'user_id' => $user_id,
            'admin' => $isAdmin,
            'product_id' => $product_id
        ]);
    }

    public function deleteImage(Image $image)
    {
        // Storage::delete([$image->url]);
        if (file_exists($image->url)) {
            unlink($image->url);
        }
        $image->delete();

        $this->product->images = $this->product->images->fresh();
    }

    public function deleteVideo(Video $video)
    {
        // Storage::delete([$image->url]);
        if (file_exists($video->url)) {
            unlink($video->url);
        }
        $video->delete();

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

        Notification::where('product_id', $this->product->id)->delete();

        $this->product->delete();

        return redirect()->route('admin.index');
    }

    public function modalImages()
    {
        $this->modalImages = !$this->modalImages;

        if ($this->modalImages) {
            $this->emit('showModalImages', $this->product->images);
        }
    }


    public function render()
    {
        $user = Auth::user();
        // $this->brands = Brand::join('brand_category', 'brands.id', 'brand_category.brand_id')
        //     ->select('brands.*')
        //     ->where('brand_category.category_id', $this->category_id)
        //     ->orderBy('name', 'asc')
        //     ->get();
        return view('livewire.admin.edit-product', compact('user'))->layout('layouts.admin');
    }
}
