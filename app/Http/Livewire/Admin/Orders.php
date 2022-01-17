<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Orders extends Component
{
    public $type;

    public function mount(){
        $this->type = 2;
    }

    public function updateType($value){
        $this->type = $value;
    }

    public function render()
    {
        // $id = $this->type == 2 ? "seller_id" : "user_id";
        $orders = Order::query()->where('status', '<>', 1);

        if (request('status')) {
            $orders->where('status', request('status'));
        }

        $role_name = Auth::user()->roles->first() ? Auth::user()->roles->first()->name : null;
        if($role_name){
            switch ($role_name) {
                case 'admin':
                    
                    break;
                case 'user':
                    $orders->where('country_id', Auth::user()->country->id);
                    break;
                
                default:
                    # code...
                    break;
            }
        }else{
            $orders->where('user_id', Auth::user()->id);
        }

        $orders = $orders->orderBy('created_at', 'desc')->get();

        $solicitudes = $orders->where('status', 2)->count();
        $pagados = $orders->where('status', 3)->count();
        $entregados = $orders->where('status', 4)->count();
        $cancelados = $orders->where('status', 5)->count();
        $camino = $orders->where('status', 6)->count();
        $todos = $solicitudes + $pagados + $entregados + $camino + $cancelados;

        return view('livewire.admin.orders', compact('solicitudes', 'pagados', 'entregados', 'cancelados', 'camino', 'todos', 'orders'))->layout('layouts.admin');
    } 
}
