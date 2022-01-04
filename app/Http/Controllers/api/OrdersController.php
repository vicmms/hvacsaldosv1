<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Video;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    // public function getOrdersById(Request $request){
    //     return Order::where('user_id', $request->input('user_id'))->get();
    // }

    public function getSalesById(Request $request){
        return Order::where('seller_id', $request->input('seller_id'))->get();
    }

    public function getPurchasesById(Request $request){
        return Order::where('user_id', $request->input('buyer_id'))->get();
    }

    public function getOrderById(Request $request){
        return Order::where('id', $request->input('order_id'))->get();
    }

    public function deleteVideo(Request $request)
    {
        $video = Video::find($request->input('id'));
        unlink($video->url);
        $video->delete();
        return json_encode("Video eliminado");
    }
}
