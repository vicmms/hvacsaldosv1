
@component('mail::message')
    <div class="cover-image">
        <img src="{{asset('images/saldo-hvac-blue.png')}}" alt="">
    </div>
    <h1>Nueva venta en espera de ser procesada</h1>
    <p>{{ $user->name }} ha soliciado comprar los siguientes articulos</p>
    @component('mail::table')
        <table>
            <thead>
                <tr>
                    <td></td>
                    <td>Producto</td>
                    <td>Cantidad</td>
                    <td>Costo Unitario</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>
                            <img class="thumbnail" src="{{ asset($order->options->image) }}" alt="">
                        </td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->qty }}</td>
                        <td>{{ $order->price }}</td>
                        <td>{{ $order->qty * $order->price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endcomponent
    <br>
    <h2>Datos del comprador</h2>
    <p>Nombre: {{ $user->name }}</p>
    <p>Correo: {{ $user->email }}</p>
    <p>Empresa: {{ $user->company_name }}</p>
    <p>Datos fiscales:</p>
    <p>{{ $user->tax_data }}</p>
    @component('mail::button', ['url' => 'https://plataforma.saldohvac.com/admin/orders'])
        Ver Ordenes
    @endcomponent
@endcomponent
