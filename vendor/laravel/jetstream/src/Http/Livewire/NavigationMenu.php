<?php

namespace Laravel\Jetstream\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NavigationMenu extends Component
{
    /**
     * The component's listeners.
     *
     * @var array
     */
    protected $listeners = [
        'refresh-navigation-menu' => '$refresh', 'newNotification'
    ];

    public $notifications = 0;

    public function newNotification($data){
        $this->notifications = Auth::user()->id;
    }
    
    public function render()
    {
        return view('navigation-menu');
    }
}
