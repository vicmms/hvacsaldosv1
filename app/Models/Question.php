<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['question', 'product_id', 'user_id'];

    use HasFactory;

    function product()
    {
        return $this->belonsTo(Product::class);
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function answer()
    {
        return $this->hasOne(Answer::class);
    }
}
