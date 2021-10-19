<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Traits\HasRoles;

use Livewire\WithPagination;

class ShowProducts extends Component
{
    use WithPagination;
    use HasRoles;
    public $search;

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
                ->where('products.name', 'like', '%' . $this->search . '%')
                ->orWhere('users.name', 'like', '%' . $this->search . '%')
                ->orderBy('status', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $products = Product::where('user_id', $user->id)
                ->where('name', 'like', '%' . $this->search . '%')->paginate(10);
        }

        return view('livewire.admin.show-products', compact('products'))->layout('layouts.admin');
    }
}
