<?php

namespace App\Http\Livewire\Admin;

use App\Http\Controllers\api\NotificationController;
use App\Mail\AcceptedProduct;
use App\Mail\RejectedProduct;
use App\Models\Notification;
use App\Models\Rejection;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class StatusProduct extends Component
{

    public $product, $status, $isOpen, $message, $buyer;

    public function mount()
    {
        $this->status = $this->product->status;
        $isOpen = 0;
        $this->buyer = User::where('id', $this->product->user_id)->first();
    }

    public function save()
    {
        if ($this->status != 3) {
            $this->product->status = $this->status;
            // si es aprobado el producto
            if ($this->product->status == 2) {
                $mail = new AcceptedProduct($this->product);
                Mail::to($this->buyer->email)->send($mail);
                $notification = 'Tu producto ha sido aprobado y ya está disponible en la página de saldo HVAC. <a class="block underline text-blue-900" href="/products/'.$this->product->slug.'">Ver producto</a>';
                $user_id = $this->product->user_id;
                $product_id = $this->product->id;
                $this->createNotification($notification, $user_id, $product_id, false);
                // notificaciones moviles
                $titulos['es'] = 'Producto aprobado!';
                $contenido['es'] = 'Tu producto ha sido aprobado y ya está disponible en la página de saldo HVAC.';
                app(NotificationController::class)->triggerNotification($titulos,$contenido, $this->product, $user_id);
            }

            $this->product->save();

            $this->emit('saved');

            event(new \App\Events\NavNotification($this->product));

            return redirect()->route('admin.index');
        }
    }

    public function rechazar()
    {
        if ($this->status == 3) {
            Rejection::create([
                'message' => $this->message,
                'product_id' => $this->product->id
            ]);

            $this->product->status = $this->status;
            $this->product->save();

            $this->emit('saved');

            $mail = new RejectedProduct($this->product);
            Mail::to($this->buyer->email)->send($mail);

            $notification = 'Tu producto no ha podido ser aprobado para su publicación, por favor revisa las observaciones realizadas. <a class="block underline text-blue-900" href="/admin/products/'.$this->product->slug.'/edit">Revisar observaciones</a>';
            $user_id = $this->product->user_id;
            $product_id = $this->product->id;
            $this->createNotification($notification, $user_id, $product_id, false);

            event(new \App\Events\NavNotification());

            // notificaciones moviles
            $titulos['es'] = 'Producto rechazado';
            $contenido['es'] = 'Tu producto no ha podido ser aprobado para su publicación, por favor revisa las observaciones realizadas.';
            app(NotificationController::class)->triggerNotification($titulos,$contenido, $this->product, $user_id);

            return redirect()->route('admin.index');
        }
    }

    public function createNotification($notification, $user_id, $product_id, $isAdmin)
    {
        Notification::create([
            'notification' => $notification,
            'user_id' => $user_id,
            'admin' => $isAdmin,
            'product_id' => $product_id
        ]);
    }

    public function changeModal()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function render()
    {
        return view('livewire.admin.status-product');
    }
}
