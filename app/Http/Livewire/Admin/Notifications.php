<?php

namespace App\Http\Livewire\Admin;

use App\Models\Notification;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notifications extends Component
{
    public function render()
    {
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->limit(120)
            ->get();
        foreach ($notifications as $notification) {
            if ($notification->product_id) {
                $product = Product::where('id', $notification->product_id)->first();
                $notification->image_url = $product->images()->first()->url;
                $notification->product_name = $product->name;
                $notification->product_slug = $product->slug;
            } else {
                $notification->image_url = null;
                $notification->product_name = null;
                $notification->product_slug = null;
            }
        }
        return view('livewire.admin.notifications', compact('notifications'))->layout('layouts.admin');
    }
}
