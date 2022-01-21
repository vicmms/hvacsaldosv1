<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getSalesData(){
        $m1 = Order::where('status', 4)->whereBetween('created_at', [Carbon::now()->subDays(30),Carbon::now()])->get();
        $m2 = Order::where('status', 4)->whereBetween('created_at', [Carbon::now()->subDays(60),Carbon::now()->subDays(30)])->get();
        $m3 = Order::where('status', 4)->whereBetween('created_at', [Carbon::now()->subDays(90),Carbon::now()->subDays(60)])->get();
        return json_encode([$m1, $m2, $m3]);
    }
}
