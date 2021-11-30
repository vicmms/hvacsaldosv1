<?php

namespace App\Http\Livewire;

use App\Models\Notification;
use App\Models\User;
use Livewire\Component;

class StatusOrder extends Component
{

    public $order, $status, $buyer;

    public function mount()
    {
        $this->status = $this->order->status;
        $this->buyer = User::where('users.id', $this->order->user_id)
                            ->join('companies', 'companies.user_id', 'users.id')
                            ->select('users.*', 'companies.name as company_name', 'companies.tax_data')
                            ->first();
    }

    public function update()
    {
        $this->order->status = $this->status;
        if ($this->order->status == 3) {
            $notification = 'Se ha registrado el pago de tu compra. <a class="block underline text-blue-900" href="/products'.json_decode($this->order->content)->options->slug.'">Ver producto</a>';
            $this->createNotification($notification, $this->order->user_id, json_decode($this->order->content)->id, false, 1);

            event(new \App\Events\NavNotification());
        }

        $this->order->save();
        $this->emit('updated');
    }

    public function createNotification($notification, $user_id, $product_id, $isAdmin, $icon)
    {
        Notification::create([
            'notification' => $notification,
            'user_id' => $user_id,
            'admin' => $isAdmin,
            'product_id' => $product_id,
            'icon' => $icon
        ]);
    }

    public function render()
    {

        $items = json_decode($this->order->content);
        $envio = json_decode($this->order->envio);

        return view('livewire.status-order', compact('items', 'envio'));
    }
}
