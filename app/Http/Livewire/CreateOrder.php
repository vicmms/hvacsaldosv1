<?php

namespace App\Http\Livewire;

use App\Mail\VentaMailable;
use App\Models\City;
use Livewire\Component;

use App\Models\Department;
use App\Models\District;
use App\Models\Notification;
use App\Models\Order;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
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
            ->where('companies.user_id', Auth::user()->id)
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

        $notification = 'Tienes nuevos pedidos en espera de ser procesados para su compra. <a class="block underline text-blue-900" href="/admin/orders?status=2">Ver pedidos</a>';

        $users = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'admin')
                    ->orWhere('name', 'user');
            }
        )
            ->where('country_id', Auth::user()->country_id)
            ->get();
        foreach ($users as $user) {
            $this->createNotification($notification, $user->id, 0, true, 2);
        }

        $notification = 'Tu compra ha sido solicitada correctamente, estaremos comunicandonos contigo lo antes posible para que puedas concluir con la compra. <a class="block underline text-blue-900" href="/orders">Ver mis pedidos</a>';
        $this->createNotification($notification, Auth::user()->id, 0, false, 1);

        Cart::destroy();

        event(new \App\Events\NavNotification());

        return redirect()->route('order.success');
    }

    public function createNotification($notification, $user_id, $product_id, $isAdmin, $icon = null)
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
        $currencies = array();
        $totales = [];
        foreach (Cart::content() as $item) {
            array_search($item->options->currency, $currencies) ? null : array_push($currencies, $item->options->currency);
            $totales[$item->options->currency] = array('currency' => $item->options->currency, 'price' => []);
        }
        foreach (Cart::content() as $item) {
            array_push($totales[$item->options->currency]['price'],  $item->price);
        }
        return view('livewire.create-order', compact('totales'));
    }
}
