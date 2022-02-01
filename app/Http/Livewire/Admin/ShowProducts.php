<?php

namespace App\Http\Livewire\Admin;

use App\Models\Notification;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Traits\HasRoles;
use Livewire\WithPagination;

class ShowProducts extends Component
{
    use WithPagination;
    use HasRoles;
    public $search, $status;

    protected $listeners = ['delete'];

    public function mount(Request $request){
        $this->status = $request->input('status') ? $request->input('status') : "";
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if($this->status){
            $condicion = '=';
            $valor = $this->status;
        }else{
            $condicion = '<>';
            $valor = 4;
        }

        $user = Auth::user();
        $role = $user->getRoleNames()->first();
        if ($role == 'admin') {
            $products = Product::join('users', 'users.id', '=', 'user_id')
                ->select('products.*', 'users.name as username')
                // ->where('products.status', $condicion, $valor)
                ->where(function($query){
                    if($this->status){
                        $condicion = '=';
                        $valor = $this->status;
                    }else{
                        $condicion = '<>';
                        $valor = 4;
                    }
                    $query->where('user_id', Auth::user()->id)
                          ->orWhere('products.status', $condicion, $valor);
                })
                ->where(function($query){
                    $query->where('products.name', 'LIKE', '%'.$this->search.'%')
                          ->orWhere('users.name', 'LIKE', '%'.$this->search.'%');
                })
                // ->where('products.name', 'like', '%' . $this->search . '%')
                // ->orWhere('users.name', 'like', '%' . $this->search . '%')
                ->orderBy('status', 'asc')
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
        } else {
            $valor = $this->status ? $this->status : 0;
            $products = Product::where('user_id', $user->id)
                ->where('name', 'like', '%' . $this->search . '%')
                ->where('products.status', $condicion, $valor)
                ->paginate(10);
        }
        session(['page' => $products->currentPage()]);
        return view('livewire.admin.show-products', compact('products'))->layout('layouts.admin');
    }
    public function delete($product_id)
    {
        $product = Product::where('id', $product_id)->first();

        $images = $product->images;

        foreach ($images as $image) {
            // Storage::delete($image->url);
            if(file_exists($image->url)){
                unlink($image->url);
            }
            $image->delete();
        }
        Notification::where('product_id', $product->id)->delete();
        $product->delete();

        // return redirect()->route('admin.index');
    }
}
