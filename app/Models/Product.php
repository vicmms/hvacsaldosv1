<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    const BORRADOR = 1;
    const PUBLICADO = 2;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //accesores

    public function getStockAttribute()
    {
        if ($this->subcategory->size) {
            return  ColorSize::whereHas('size.product', function (Builder $query) {
                $query->where('id', $this->id);
            })->sum('quantity');
        } elseif ($this->subcategory->color) {
            return  ColorProduct::whereHas('product', function (Builder $query) {
                $query->where('id', $this->id);
            })->sum('quantity');
        } else {

            return $this->quantity;
        }
    }


    //Relacion uno a muchos
    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function rejections(){
        return $this->hasMany(Rejection::class);
    }

    //Relacion uno a muchos inversa
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
        // return $this->hasOneThrough(Country::class, State::class);
    }

    // public function country()
    // {
    //     return State::with('countries')->where('country.id', Auth::user()->country_id);
    // }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Relacion muchos a muchos
    public function colors()
    {
        return $this->belongsToMany(Color::class)->withPivot('quantity', 'id');
    }


    //relacion uno a muchos polimoefica
    public function images()
    {
        return $this->morphMany(Image::class, "imageable");
    }

    //URL AMIGABLES
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
