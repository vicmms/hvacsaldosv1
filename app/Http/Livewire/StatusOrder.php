<?php

namespace App\Http\Livewire;

use App\Models\Notification;
use Livewire\Component;

class StatusOrder extends Component
{

    public $order, $status;

    public function mount()
    {
        $this->status = $this->order->status;
    }

    public function update()
    {
        $this->order->status = $this->status;
        if ($this->order->status == 3) {
            $notification = 'Se ha registrado el pago de tu compra';
            $this->createNotification($notification, $this->order->user_id, false);

            event(new \App\Events\NavNotification());
        }

        $this->order->save();
    }

    public function createNotification($notification, $user_id, $isAdmin)
    {
        Notification::create([
            'notification' => $notification,
            'user_id' => $user_id,
            'admin' => $isAdmin
        ]);
    }

    public function render()
    {

        $items = json_decode($this->order->content);
        $envio = json_decode($this->order->envio);

        return view('livewire.status-order', compact('items', 'envio'));
    }
}
