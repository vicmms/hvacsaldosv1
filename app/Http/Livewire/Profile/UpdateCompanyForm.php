<?php

namespace App\Http\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UpdateCompanyForm extends Component
{
    public $name, $data;

    public function mount()
    {
        $company = DB::table('companies')
            ->where('user_id', Auth::user()->id)
            ->first();
        if($company){
            $this->name = $company->name;
            $this->data = $company->tax_data;
        }
    }

    public function save()
    {
        DB::table('companies')
            ->updateOrInsert(
                ['user_id' => Auth::user()->id],
                [
                    'name' => $this->name,
                    'tax_data' => $this->data,
                ]
            );
        $this->emit('saved');
    }

    public function render()
    {
        return view('livewire..profile.update-company-form');
    }
}
