<?php

namespace App\Http\Livewire;

use App\Mail\VentaMailable;
use App\Models\City;
use Livewire\Component;

use App\Models\Department;
use App\Models\District;
use App\Models\Order;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;

class CreateOrder extends Component
{

    public $envio_type = 1;

    public $user;

    public $departments, $cities = [], $districts = [];

    public $department_id = "", $city_id = "", $district_id = "";

    // public $rules = [
    //     'contact' => 'required',
    //     'phone' => 'required',
    //     'envio_type' => 'required'
    // ];

    public function mount()
    {
        $this->user = User::join('companies', 'companies.user_id', 'users.id')
            ->select('users.*', 'companies.name as company_name', 'companies.tax_data')
            ->first();
        $this->departments = Department::all();
    }

    public function updatedEnvioType($value)
    {
        if ($value == 1) {
            $this->resetValidation([
                'department_id', 'city_id', 'district_id', 'address', 'references'
            ]);
        }
    }


    public function updatedDepartmentId($value)
    {
        $this->cities = City::where('department_id', $value)->get();

        $this->reset(['city_id', 'district_id']);
    }


    public function updatedCityId($value)
    {

        $city = City::find($value);

        $this->shipping_cost = $city->cost;

        $this->districts = District::where('city_id', $value)->get();

        $this->reset('district_id');
    }


    public function create_order()
    {
        $this->user = User::join('companies', 'companies.user_id', 'users.id')
            ->select('users.*', 'companies.name as company_name', 'companies.tax_data')
            ->first();
        foreach (Cart::content() as $item) {

            $order = new Order();

            $order->user_id = auth()->user()->id;
            $order->contact = $this->user->name;
            $order->status = 2;
            $order->total = $item->price * $item->qty;
            $order->content = json_encode($item);

            $order->save();


            discount($item);
        }
        $mail = new VentaMailable(Cart::content(), $this->user);
        $emails = array("administracion@saldohvac.com", "victor.morales@nanodela.com");
        Mail::to($emails)->send($mail);

        Cart::destroy();

        return redirect()->route('order.success');
    }

    public function render()
    {
        return view('livewire.create-order');
    }
}
