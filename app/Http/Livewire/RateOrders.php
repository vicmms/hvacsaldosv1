<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RateOrders extends Component
{
    public $isOpen, $order, $rating, $comments, $stars;


    public function mount()
    {
        $this->rating = Rating::where('order_id', $this->order->id)->first();
        if ($this->rating) {
            $this->stars = $this->rating->score;
            $this->comments = $this->rating->comments;
        }
    }

    public function changeModal()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function setStars($stars)
    {
        $this->stars = $stars;
    }

    public function resetStars()
    {
        $this->stars = 0;
    }

    public function save()
    {
        $product = Product::where('id', json_decode($this->order->content)->id)->first();

        Rating::create([
            "score" => $this->stars,
            "comments" => $this->comments,
            "user_id" => Auth::user()->id,
            "seller_id" => $product->user_id,
            "order_id" => $this->order->id
        ]);
        $this->changeModal();
    }
    public function render()
    {
        return view('livewire.rate-orders');
    }
}
