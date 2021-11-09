<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class RejectionRecord extends Component
{
    public $rejections, $product;
    public function render()
    {
        return view('livewire.admin.rejection-record');
    }
}
