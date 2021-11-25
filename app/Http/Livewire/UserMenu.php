<?php

namespace App\Http\Livewire;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserMenu extends Component
{
    protected $listeners = ['updateMainNotifications'];

    public function updateMainNotifications(){
        $this->render();
    }
    public function render()
    {
        $notifications = null;
        if(Auth::check()){
            $notifications = Notification::where('notifications.user_id', Auth::user()->id)
                                    ->where('read', false)
                                    ->count();
        }
        
        return view('livewire.user-menu', compact('notifications'));
    }
}
