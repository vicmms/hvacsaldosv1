<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;

use Livewire\WithPagination;

class ShowProducts extends Component
{
    use WithPagination;
    use HasRoles;
    public $search;

    protected $listeners = ['delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $user = Auth::user();
        $role = $user->getRoleNames()->first();
        if ($role == 'admin') {
            $products = Product::join('users', 'users.id', '=', 'user_id')
                ->select('products.*', 'users.name as username')
                ->where('products.status', '<>', 4)
                ->where(function($query){
                    $query->where('products.name', 'LIKE', '%'.$this->search.'%')
                          ->orWhere('users.name', 'LIKE', '%'.$this->search.'%');
                })
                // ->where('products.name', 'like', '%' . $this->search . '%')
                // ->orWhere('users.name', 'like', '%' . $this->search . '%')
                ->orderBy('status', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $products = Product::where('user_id', $user->id)
                ->where('name', 'like', '%' . $this->search . '%')->paginate(10);
        }

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

        $product->delete();

        // return redirect()->route('admin.index');
    }
}
