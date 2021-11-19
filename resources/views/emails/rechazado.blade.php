@component('mail::message')
    <h1>Tu producto ha sido rechazado</h1>
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
                        <img class="thumbnail" src="https://plataforma.saldohvac.com/{{ $product->images->first()->url }}"
                            alt="">
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ explode(' ', $product->created_at)[0] }}</td>
                </tr>
            </tbody>
        </table>
    @endcomponent
    <br>
    <p>Tu producto ha sido rechazado por los siguientes motivos</p>
    <div class="rejected">
        <p>{{$product->rejections->last()->message}}</p>
    </div>  
    @component('mail::button', ['url' => 'https://plataforma.saldohvac.com/admin/products/'.$product->slug.'/edit'])
        Ver producto
    @endcomponent
@endcomponent
