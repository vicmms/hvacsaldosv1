<?php

namespace App\Http\Livewire;

use App\Models\Notification;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationsBell extends Component
{
    protected $listeners = ['newBellNotification'];

    public function newBellNotification()
    {
        $this->render();
    }

    public function clearNotifications()
    {
        Notification::where('user_id', Auth::user()->id)
            ->where('read', false)
            ->update(['read' => true]);
    }

    public function readNotification($id)
    {
        Notification::where('id', $id)
            ->update(['read' => true]);
    }

    public function render()
    {
        $notifications_count = Notification::where('user_id', Auth::user()->id)
            ->where('read', false)
            ->count();

        $notifications = Notification::where('user_id', Auth::user()->id)
            // ->orderBy('read', 'asc')
            ->orderBy('notifications.created_at', 'desc')
            ->limit(10)
            ->get();
        foreach ($notifications as $notification) {
            $product = Product::where('id', $notification->product_id)->first();
            $notification->image_url = null;
            $notification->product_name = null;
            $notification->product_slug = null;
            if ($notification->product_id) {
                if ($product) {
                    $notification->image_url = $product->images()->count() ? $product->images()->first()->url : 'images/image-not-found.png';
                    $notification->product_name = $product->name;
                    $notification->product_slug = $product->slug;
                }
            }
        }
        $notifications->number = $notifications_count;
        return view('livewire.notifications-bell', compact('notifications'));
    }
}
