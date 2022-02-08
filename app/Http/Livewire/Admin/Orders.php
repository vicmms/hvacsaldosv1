<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Orders extends Component
{
    public $type, $status, $filter_orders;

    public function mount(){
        $this->type = 2;
    }

    public function updateType($value){
        $this->type = $value;
    }

    public function updateStatus($value = null){
        $this->status = $value;
    }

    public function updatedFilterOrders(){
        $this->updateStatus($this->filter_orders);
    }

    public function render()
    {
        // $id = $this->type == 2 ? "seller_id" : "user_id";
        $orders = Order::query()->where('status', '<>', 1);

        if ($this->status) {
            $orders->where('status', $this->status);
        }
        
        if (request('status')) {
            $orders->where('status', request('status'));
        }

        $role_name = Auth::user()->roles->first() ? Auth::user()->roles->first()->name : null;
        if($role_name){
            switch ($role_name) {
                case 'admin':
                    $solicitudes = Order::where('status', 2)->count();
                    $pagados = Order::where('status', 3)->count();
                    $entregados = Order::where('status', 4)->count();
                    $cancelados = Order::where('status', 5)->count();
                    $camino = Order::where('status', 6)->count();
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
            $solicitudes = Order::where('status', 2)->where('user_id', Auth::user()->id)->count();
            $pagados = Order::where('status', 3)->where('user_id', Auth::user()->id)->count();
            $entregados = Order::where('status', 4)->where('user_id', Auth::user()->id)->count();
            $cancelados = Order::where('status', 5)->where('user_id', Auth::user()->id)->count();
            $camino = Order::where('status', 6)->where('user_id', Auth::user()->id)->count();
        }

        $orders = $orders->orderBy('created_at', 'desc')->get();

        
        $todos = $solicitudes + $pagados + $entregados + $camino + $cancelados;

        return view('livewire.admin.orders', compact('solicitudes', 'pagados', 'entregados', 'cancelados', 'camino', 'todos', 'orders'))->layout('layouts.admin');
    } 
}
