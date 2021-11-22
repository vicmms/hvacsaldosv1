<?php

namespace App\Http\Livewire;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationsBell extends Component
{
    protected $listeners = ['newBellNotification'];

    public function newBellNotification(){
        $this->render();
    }
    public function render()
    {
        $notifications = Notification::where('user_id', Auth::user()->id)
                                    ->where('read', false)
                                    ->orderBy('created_at', 'desc')
                                    ->limit(10)
                                    ->get();
        return view('livewire.notifications-bell', compact('notifications'));
    }
}
