<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rejection extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'product_id'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
