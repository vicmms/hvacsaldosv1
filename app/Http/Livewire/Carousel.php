<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Carousel extends Component
{

    public $images;

    public function render()
    {
        return view('livewire.carousel');
    }
}
