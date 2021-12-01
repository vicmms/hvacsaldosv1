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


        $solicitudes = $orders->where('status', 2)->count();
        $pagados = $orders->where('status', 3)->count();
        $entregados = $orders->where('status', 4)->count();
        $cancelados = $orders->where('status', 5)->count();
        $todos = $solicitudes + $pagados + $entregados + $cancelados;

        // $pendiente = Order::where('status', 1)->count();
        // $recibido = Order::where('status', 2)->count();
        // $enviado = Order::where('status', 3)->count();
        // $entregado = Order::where('status', 4)->count();
        // $anulado = Order::where('status', 5)->count();

        return view('admin.orders.index', compact('solicitudes', 'pagados', 'entregados', 'cancelados', 'todos', 'orders'));
    }  

    public function show(Order $order){
        return view('admin.orders.show', compact('order'));
    }
}
