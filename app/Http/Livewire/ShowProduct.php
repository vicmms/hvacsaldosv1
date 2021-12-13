<?php

namespace App\Http\Livewire;

use App\Models\Answer;
use App\Models\Product;
use App\Models\Question;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShowProduct extends Component
{
    use WithPagination;

    protected $listeners = ['render'];

    public $isDisabled = false, $formData;

    public $product, $question;

    protected $rules = [
        'formData.answer' => 'required|max:255',
    ];

    public function mount(Product $product, Question $question)
    {
        $this->product = $product;
        $this->question = $question;
    }

    public function saveAnswer($formData, $question_id)
    {
        $this->formData = $formData;
        $this->validate();
        // dd($formData);
        if (strlen($formData['answer'])) {
            Answer::create([
                'answer' => $formData['answer'],
                'question_id' => $question_id,
                'user_id' => Auth::user()->id
            ]);
        }
    }

    public function render()
    {
        $product = $this->product;
        $seller = Rating::where('seller_id', $product->user_id)->get();
        $seller->score = number_format(Rating::where('seller_id', $product->user_id)->avg('score'), 1, '.', ',');
        $questions = Question::with('answer')->where('product_id', $product->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('livewire.show-product', compact('product', 'questions', 'seller'));
    }
}
