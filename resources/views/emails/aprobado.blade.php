@component('mail::message')
    <h1>Tu producto ha sido aprobado</h1>
    @component('mail::table')
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Producto</th>
                    <th>Fecha en que se subió</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <img class="thumbnail" src="https://plataforma.saldohvac.com/{{ $product->images->first()->url }}" alt="">
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ explode(" ", $product->created_at)[0] }}</td>
                </tr>
            </tbody>
        </table>
    @endcomponent
    <br>
    <p>Tu producto ya está publicado en nuestra plataforma, serás notificado cuando sea vendido. ¡Mucha suerte!</p>
    @component('mail::button', ['url' => 'https://plataforma.saldohvac.com'])
        Ir a SaldoHVAC
    @endcomponent
@endcomponent
