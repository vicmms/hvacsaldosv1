<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

use Livewire\WithPagination;

class UserComponent extends Component
{

    use WithPagination;

    public $search;
    protected $listeners = ['deleteUser'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function assignRole(User $user, $value)
    {

        switch ($value) {
            case '1':
                $user->assignRole('user');
                $user->removeRole('admin');
                break;
            case '2':
                $user->assignRole('admin');
                $user->removeRole('user');
                break;

            default:
                $user->removeRole('admin');
                $user->removeRole('user');
                break;
        }
    }

    public function deleteUser(User $user){
        $user->delete();
    }

    public function render()
    {

        $users = User::where('email', '<>', auth()->user()->email)
            ->where(function ($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
                $query->orWhere('email', 'LIKE', '%' . $this->search . '%');
            })->paginate();

        return view('livewire.admin.user-component', compact('users'))->layout('layouts.admin');
    }
}
