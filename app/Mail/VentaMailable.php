<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Collection;

class VentaMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Nueva venta Saldohvac";
    public $orders, $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection|null $orders, User $user)
    {
        $this->orders = $orders;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.venta');
    }
}
