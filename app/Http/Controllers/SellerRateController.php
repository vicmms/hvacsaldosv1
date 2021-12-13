<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class SellerRateController extends Controller
{
    public function show($id){
        $id = decrypt($id);
        $califications = Rating::where('seller_id', $id)
        ->join('users', 'users.id', 'ratings.user_id')
        ->select('ratings.*', 'users.name')                
        ->get();

        $seller = User::where('id', $id)->first();
        return view('seller-rate',compact('califications', 'seller'));
    }
}
