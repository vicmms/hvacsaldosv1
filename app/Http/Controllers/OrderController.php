<?php

namespace App\Http\Controllers;

use App\Models\Cancellation;
use App\Models\Order;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index()
    {

        $orders = Order::query()->where('user_id', auth()->user()->id);

        if (request('status')) {
            $orders->where('status', request('status'));
        }

        $orders = $orders->orderBy('created_at', 'desc')->get();


        $solicitudes = Order::where('status', 2)->where('user_id', auth()->user()->id)->count();
        $pagados = Order::where('status', 3)->where('user_id', auth()->user()->id)->count();
        $entregados = Order::where('status', 4)->where('user_id', auth()->user()->id)->count();
        $cancelados = Order::where('status', 5)->where('user_id', auth()->user()->id)->count();
        $todos = $solicitudes + $pagados + $entregados + $cancelados;

        // return view('dashboard');
        return view('orders.index', compact('solicitudes', 'pagados', 'entregados', 'cancelados', 'todos', 'orders'));
    }

    public function show(Order $order)
    {
        $comments = null;
        $this->authorize('author', $order);

        $items = json_decode($order->content);
        $envio = json_decode($order->envio);
        if($order->status == 5){
            $comments = Cancellation::where('order_id', $order->id)->first()->comments;
        }

        return view('orders.show', compact('order', 'items', 'envio', 'comments'));
    }


    public function pay(Order $order, Request $request)
    {

        $this->authorize('author', $order);

        $payment_id = $request->get('payment_id');

        $response = Http::get("https://api.mercadopago.com/v1/payments/$payment_id" . "?access_token=APP_USR-2966754438242803-052115-15da96c087a2fc4d07794f08fe496606-763006654");

        $response = json_decode($response);

        $status = $response->status;

        if ($status == 'approved') {
            $order->status = 2;
            $order->save();
        }

        return redirect()->route('orders.show', $order);
    }

    public function success()
    {
        return view('orders.success');
    }
}
