<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'order_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    //relacion uno a muchos polimoefica
    public function images()
    {
        return $this->morphMany(Image::class, "imageable");
    }

    public function videos()
    {
        return $this->morphMany(Video::class, "item");
    }
}
