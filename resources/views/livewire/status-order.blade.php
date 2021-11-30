<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">


    <div class="bg-white rounded-lg shadow-lg px-12 py-8 mb-6 flex items-center">

        <div class="relative">
            <div
                class="{{ $order->status >= 2 && $order->status != 5 ? 'bg-blue-400' : 'bg-gray-400' }}  rounded-full h-12 w-12 flex items-center justify-center">
                <i class="fas fa-check text-white"></i>
            </div>

            <div class="absolute -left-1.5 mt-0.5">
                <p>Solicitado</p>
            </div>
        </div>

        <div class="{{ $order->status >= 3 && $order->status != 5 ? 'bg-blue-400' : 'bg-gray-400' }} h-1 flex-1 mx-2">
        </div>

        <div class="relative">
            <div
                class="{{ $order->status >= 3 && $order->status != 5 ? 'bg-blue-400' : 'bg-gray-400' }} rounded-full h-12 w-12 flex items-center justify-center">
                <i class="fas fa-truck text-white"></i>
            </div>

            <div class="absolute -left-1 mt-0.5">
                <p>Pagado</p>
            </div>
        </div>

        <div class="{{ $order->status >= 4 && $order->status != 5 ? 'bg-blue-400' : 'bg-gray-400' }} h-1 flex-1 mx-2">
        </div>

        <div class="relative">
            <div
                class="{{ $order->status >= 4 && $order->status != 5 ? 'bg-blue-400' : 'bg-gray-400' }} rounded-full h-12 w-12 flex items-center justify-center">
                <i class="fas fa-check text-white"></i>
            </div>

            <div class="absolute -left-2 mt-0.5">
                <p>Entregado</p>
            </div>
        </div>

    </div>



    @role('admin')
        <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6">
            <p class="text-gray-700 uppercase"><span class="font-semibold">Número de orden:</span>
                Orden-{{ $order->id }}</p>

            <form wire:submit.prevent="update">
                <div class="flex space-x-3 mt-2">
                    <x-jet-label>
                        <input wire:model="status" type="radio" name="status" value="2" class="mr-2">
                        Solicitado
                    </x-jet-label>

                    <x-jet-label>
                        <input wire:model="status" type="radio" name="status" value="3" class="mr-2">
                        Pagado
                    </x-jet-label>

                    <x-jet-label>
                        <input wire:model="status" type="radio" name="status" value="4" class="mr-2">
                        Entregado
                    </x-jet-label>

                    <x-jet-label>
                        <input wire:model="status" type="radio" name="status" value="5" class="mr-2">
                        Cancelado
                    </x-jet-label>
                </div>

                <div class="flex mt-2 justify-end items-center">
                    <x-jet-action-message class="mr-3" on="updated">
                        Actualizado
                    </x-jet-action-message>
                    <x-jet-button class="mr-4">
                        Actualizar
                    </x-jet-button>
                </div>
            </form>
        </div>
    @endrole


    {{-- <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="grid grid-cols-2 gap-6 text-gray-700">
            <div>
                <p class="text-lg font-semibold uppercase">Envío</p>

                @if ($order->envio_type == 1)
                    <p class="text-sm">Los productos deben ser recogidos en tienda</p>
                    <p class="text-sm">Calle falsa 123</p>
                @else
                    <p class="text-sm">Los productos Serán enviados a:</p>
                    <p class="text-sm">adresss</p>
                    <p>{{ $envio->department }} - {{ $envio->city }} - {{ $envio->district }}
                    </p>
                @endif


            </div>

            <div>
                <p class="text-lg font-semibold uppercase">Datos de contacto</p>

                <p class="text-sm">Persona que recibirá el producto: {{ $order->contact }}</p>
                <p class="text-sm">Teléfono de contacto: {{ $order->phone }}</p>
            </div>
        </div>
    </div> --}}

    <div class="bg-white rounded-lg shadow-lg p-6 text-gray-700 mb-6" wire:ignore>
        <div class="flex">
            <p class="flex-1 text-xl font-semibold mb-4">Resumen</p>
            <a class="self-stretch text-lg" href="{{ route('admin.orders.index') }}">
                <i class="fas fa-arrow-left text-lg"></i> Regresar
            </a>
        </div>
        <hr>
        <p class="my-4 text-lg font-semibold">Información del Comprador </p>
        <div class="mb-4 font-semibold">
            <p>Nombre: {{ $buyer->name }}</p>
            <p>Correo: {{ $buyer->email }}</p>
            <p>Empresa: {{ $buyer->company_name }}</p>
            <p>Datos fiscales: </p>
            <p class="whitespace-pre-line ml-2">{{ $buyer->tax_data }}</p>
        </div>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio unitario</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                <td>
                    <div class="flex">
                        <img class="h-15 w-20 object-cover mr-4"
                            src="{{ asset($items->options->image ? $items->options->image : 'images/image-not-found.png') }}"
                            alt="">
                        <article>
                            <h1 class="font-bold">{{ $items->name }}</h1>
                            <div class="flex text-xs">

                                @isset($items->options->color)
                                    Color: {{ __($items->options->color) }}
                                @endisset

                                @isset($items->options->size)
                                    - {{ $items->options->size }}
                                @endisset
                            </div>
                        </article>
                    </div>
                </td>

                <td class="text-center">
                    {{ $items->price }} USD
                </td>

                <td class="text-center">
                    {{ $items->qty }}
                </td>

                <td class="text-center">
                    {{ $items->price * $items->qty }} USD
                </td>
                </tr>
            </tbody>
        </table>
    </div>



</div>
