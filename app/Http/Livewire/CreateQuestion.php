<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateQuestion extends Component
{

    public $question, $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function addQuestion()
    {
        if (strlen($this->question)) {
            Question::create([
                'question' => $this->question,
                'product_id' => $this->product->id,
                'user_id' => Auth::user()->id,
            ]);
            $this->emitTo('show-product', 'render');
            $this->question = "";
        }
    }

    public function render()
    {
        return view('livewire.create-question');
    }
}
