<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Image;
use App\Models\Product;
use App\Models\State;
use App\Models\User;
use App\Models\Currency;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function getProducts(Request $request)
    {
        // $products = Product::all();
        $products = Product::with('images')->where('products.user_id', $request->input('user_id'))->get();
        return $products;
    }

    public function getStates(Request $request)
    {
        // $products = Product::all();
        $states = State::where('states.country_id', $request->input('country_id'))->get();
        return $states;
    }

    public function getCountries(Request $request)
    {
        return Country::all();
    }
    public function getCurrencies(Request $request)
    {
        return Currency::all();
    }

    public function getProductById(Request $request)
    {
        return Product::with('images')->where('products.id',  $request->input('id'))
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('subcategories', 'subcategories.id', '=', 'products.subcategory_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->join('states', 'states.id', '=', 'products.state_id')
            ->select('products.*', 'categories.name as category_name', 'subcategories.name as subcategory_name', 'brands.name as brand_name', 'states.name as state_name')
            ->get();
    }

    public function setProduct(Request $request)
    {
        $product = new Product;

        $product->name = $request->input('name');
        $product->slug = Str::slug($request->input('name') . " " . rand(10,99) . $request->input('user_id'));
        $product->description = $request->input('description');
        $product->model = $request->input('model');
        $product->serie_number = $request->input('serie_number');
        $product->shipping = $request->input('shipping');
        $product->shipping_cost = $request->input('shipping_cost');
        $product->price = $request->input('price');
        $product->unit = $request->input('unit');
        $product->commercial_price = $request->input('commercial_price');
        $product->subcategory_id = $request->input('subcategory_id');
        $product->category_id = $request->input('category_id');
        $product->brand_id = $request->input('brand_id');
        $product->quantity = $request->input('quantity');
        $product->user_id = $request->input('user_id');
        $product->state_id = $request->input('state_id');
        $product->currency_id = $request->input('currency_id');
        $product->city = $request->input('city');
        $product->status = $request->input('status');
        $product->save();

        if ($request->input('photos')) {

            for ($i = 0; $i < count($request->input('photos')[0]); $i++) {
                $file = $request->input('photos')[0][$i];
                $data = $file['base64Data'];

                if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
                    $data = substr($data, strpos($data, ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif

                    if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                        throw new \Exception('invalid image type');
                    }
                    $data = str_replace(' ', '+', $data);
                    $data = base64_decode($data);

                    if ($data === false) {
                        throw new \Exception('base64_decode failed');
                    }
                } else {
                    throw new \Exception('did not match data URI with image data');
                }
                $url = './images/admin/products/' . date("YmdHis") . $i . '.' . $type;
                file_put_contents($url, $data);
                $product->images()->create([
                    'url' => $url
                ]);
            }
        }

        if($product->status == 1){
            $country_id = User::where('id', $request->input('user_id'))->first()->country_id;
            $users = User::whereHas(
                'roles',
                function ($q) {
                    $q->where('name', 'admin')->orWhere('name', 'user');
                }
            )
                ->where('country_id', $country_id)
                ->get();
            foreach ($users as $user) {
                Notification::create([
                    'notification' => '(App) Se ha solicitado la revisión de un nuevo producto. <a class="block underline text-blue-900" href="/admin?status=1">Ver solicitudes</a>',
                    'user_id' => $user->id,
                    'admin' => true,
                    'product_id' => $product->id
                ]);
            }
    
            event(new \App\Events\NavNotification());
        }
        
        return json_encode("Producto registrado");
    }

    public function updateProduct(Request $request)
    {
        Product::with('images')->where('id',  $request->input('id'))
            ->update([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
                'description' => $request->input('description'),
                'model' => $request->input('model'),
                'serie_number' => $request->input('serie_number'),
                'shipping' => $request->input('shipping'),
                'shipping_cost' => $request->input('shipping_cost'),
                'price' => $request->input('price'),
                'commercial_price' => $request->input('commercial_price'),
                'subcategory_id' => $request->input('subcategory_id'),
                'category_id' => $request->input('category_id'),
                'brand_id' => $request->input('brand_id'),
                'quantity' => $request->input('quantity'),
                'state_id' => $request->input('state_id'),
                'status' => $request->input('status'),
                'city' => $request->input('city'),
                'currency_id'=> $request->input('currency_id')
            ]);
        $product = Product::find($request->input('id'));
        if ($request->input('photos')) {

            for ($i = 0; $i < count($request->input('photos')[0]); $i++) {
                $file = $request->input('photos')[0][$i];
                $data = $file['base64Data'];

                if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
                    $data = substr($data, strpos($data, ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif

                    if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                        throw new \Exception('invalid image type');
                    }
                    $data = str_replace(' ', '+', $data);
                    $data = base64_decode($data);

                    if ($data === false) {
                        throw new \Exception('base64_decode failed');
                    }
                } else {
                    throw new \Exception('did not match data URI with image data');
                }
                $url = './images/admin/products/' . date("YmdHis") . $i . '.' . $type;
                file_put_contents($url, $data);
                $product->images()->create([
                    'url' => $url
                ]);
            }
        }
        return json_encode("Actualizado");
    }

    public function deleteProductPhoto(Request $request)
    {
        $image = Image::find($request->input('id'));
        unlink($image->url);
        $image->delete();
        return json_encode("Foto eliminada");
    }

    public function deleteProduct(Request $request)
    {
        $product = Product::find($request->input('id'));

        $product->delete();

        return json_encode("Registro eliminado");
    }
}
