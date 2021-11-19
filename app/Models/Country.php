<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'image', 'icon'];


    // public function products()
    // {
    //     return $this->hasMany(Product::class);
    // }
    public function products()
    {
        return $this->hasManyThrough(Product::class, State::class);
    }

    public function states()
    {
        return $this->hasMany(State::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
