<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){

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

        $solicitudes = Order::where('status', 2)->count();
        $pagados = Order::where('status', 3)->count();
        $entregados = Order::where('status', 4)->count();
        $cancelados = Order::where('status', 5)->count();
        $camino = Order::where('status', 6)->count();
        $todos = $solicitudes + $pagados + $entregados + $camino + $cancelados;

        return view('admin.orders.index', compact('solicitudes', 'pagados', 'entregados', 'cancelados', 'camino', 'todos', 'orders'));
    }  

    public function show(Order $order){
        return view('admin.orders.show', compact('order'));
    }
}
