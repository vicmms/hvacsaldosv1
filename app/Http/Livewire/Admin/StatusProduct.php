<?php

namespace App\Http\Livewire\Admin;

use App\Models\Rejection;
use Livewire\Component;

class StatusProduct extends Component
{

    public $product, $status, $isOpen, $message;

    public function mount(){
        $this->status = $this->product->status;
        $isOpen = 0;
    }

    public function save(){
        $this->product->status = $this->status;
        $this->product->save();

        $this->emit('saved');

        return redirect()->route('admin.index');
    }

    public function rechazar(){
        Rejection::create([
            'message' => $this->message,
            'product_id' => $this->product->id
        ]);

        $this->product->status = $this->status;
        $this->product->save();

        $this->emit('saved');

        return redirect()->route('admin.index');
    }

    public function changeModal(){
        $this->isOpen = !$this->isOpen;
    }

    public function render()
    {
        return view('livewire.admin.status-product');
    }
}
