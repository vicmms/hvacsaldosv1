<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancellation extends Model
{
    use HasFactory;

    public $fillable = ['comments', 'user_id', 'order_id'];

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
