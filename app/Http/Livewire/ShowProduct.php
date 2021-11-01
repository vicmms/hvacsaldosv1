<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Question;
use Livewire\Component;
use Livewire\WithPagination;

class ShowProduct extends Component
{
    use WithPagination;

    protected $listeners = ['render'];

    public $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    // public function refreshQuestions()
    // {
    //     $message = "wrong answer";
    //     echo "<script type='text/javascript'>alert('$message');</script>";
    // }

    public function render()
    {
        $product = $this->product;
        $questions = Question::with('answer')->where('product_id', $product->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('livewire.show-product', compact('product', 'questions'));
    }
}
