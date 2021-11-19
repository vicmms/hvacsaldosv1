<?php

namespace App\Http\Livewire\Admin;

use App\Mail\AcceptedProduct;
use App\Mail\RejectedProduct;
use App\Models\Rejection;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class StatusProduct extends Component
{

    public $product, $status, $isOpen, $message, $buyer;

    public function mount(){
        $this->status = $this->product->status;
        $isOpen = 0;
        $this->buyer = User::where('id', $this->product->user_id)->first();
    }

    public function save(){
        if($this->status != 3){
            $this->product->status = $this->status;
            if($this->product->status == 2){
                $mail = new AcceptedProduct($this->product);
                Mail::to($this->buyer->email)->send($mail);
            }

            $this->product->save();

            $this->emit('saved');

            event(new \App\Events\NavNotification(Auth::user(), "pusher notification"));

            // return redirect()->route('admin.index');
        }
    }

    public function rechazar(){
        if($this->status == 3){
            Rejection::create([
                'message' => $this->message,
                'product_id' => $this->product->id
            ]);
    
            $this->product->status = $this->status;
            $this->product->save();
    
            $this->emit('saved');

            $mail = new RejectedProduct($this->product);
            Mail::to($this->buyer->email)->send($mail);
    
            return redirect()->route('admin.index');
        }
    }

    public function changeModal(){
        $this->isOpen = !$this->isOpen;
    }

    public function render()
    {
        return view('livewire.admin.status-product');
    }
}
