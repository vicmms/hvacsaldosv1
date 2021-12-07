@component('mail::message')
    <h1>Nueva venta en espera de ser procesada</h1>
    <p>{{ $user->name }} ha soliciado comprar los siguientes articulos</p>
    @component('mail::table')
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Costo Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @if ($orders)
                    @foreach ($orders as $order)
                        <tr>
                            <td>
                                <img class="thumbnail" src="https://plataforma.saldohvac.com/{{ json_decode($order->options)->image }}"
                                    alt="">
                            </td>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->qty }}</td>
                            <td>{{ $order->price }}</td>
                            <td>{{ $order->qty * $order->price }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    @endcomponent
    <br>
    <h2>Datos del comprador</h2>
    <p>Nombre: {{ $user->name }}</p>
    <p>Correo: {{ $user->email }}</p>
    <p>Empresa: {{ $user->company_info ? $user->company_info->name : 'Sin información'}}</p>
    @component('mail::button', ['url' => 'https://plataforma.saldohvac.com/admin/orders'])
        Ver Ordenes
    @endcomponent
@endcomponent
