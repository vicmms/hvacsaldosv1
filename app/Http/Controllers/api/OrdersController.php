<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function getOrdersById(Request $request){
        return Order::where('user_id', $request->input('user_id'))->get();
    }

    public function getOrderById(Request $request){
        return Order::where('id', $request->input('order_id'))->get();
    }
}
