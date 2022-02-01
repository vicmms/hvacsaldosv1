<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Cache\NullStore;
use Livewire\Component;

class Orders extends Component
{
    public $orders, $type = 1, $filter_orders, $status;

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
        $id = $this->type == 2 ? "seller_id" : "user_id";
        $orders = Order::query()->where($id, auth()->user()->id);
        
        if ($this->status) {
            $orders->where('status', $this->status);
        }
        
        $orders = $orders->orderBy('created_at', 'desc')->get();
        
        
        $solicitudes = Order::where('status', 2)->where($id, auth()->user()->id)->count();
        $pagados = Order::where('status', 3)->where($id, auth()->user()->id)->count();
        $entregados = Order::where('status', 4)->where($id, auth()->user()->id)->count();
        $cancelados = Order::where('status', 5)->where($id, auth()->user()->id)->count();
        $camino = Order::where('status', 6)->where($id, auth()->user()->id)->count();
        $todos = $solicitudes + $pagados + $entregados + $cancelados + $camino;
        $this->orders = $orders;
        return view('livewire.orders', compact('solicitudes', 'pagados', 'camino', 'entregados', 'cancelados', 'todos', 'orders'));
    }
}
