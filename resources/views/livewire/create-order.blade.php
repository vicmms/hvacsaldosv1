<div class="container py-8 grid lg:grid-cols-2 xl:grid-cols-5 gap-6">

    <div class="order-2 lg:order-1 lg:col-span-1 xl:col-span-3">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="mb-4">
                <x-jet-label value="Nombre de contácto" />
                <x-jet-input type="text" disabled class="w-full" value="{{ $user->name }}" />
            </div>

            <div class="mb-4">
                <x-jet-label value="Empresa" />
                <x-jet-input type="text" disabled class="w-full" value="{{ $user->company_name }}" />
            </div>

            <div class="mb-4">
                <x-jet-label value="Datos de facturación" />
                <textarea rows="5" disabled class="form-control w-full">{{ $user->tax_data }}</textarea>
            </div>
        </div>

        {{-- <div x-data="{ envio_type: @entangle('envio_type') }">
            <p class="mt-6 mb-3 text-lg text-gray-700 font-semibold">Envíos</p>

            <label class="bg-white rounded-lg shadow px-6 py-4 flex items-center mb-4 cursor-pointer">
                <input x-model="envio_type" type="radio" value="1" name="envio_type" class="text-gray-600">
                <span class="ml-2 text-gray-700">
                    Recojo en tienda (Calle Falsa 123)
                </span>

                <span class="font-semibold text-gray-700 ml-auto">
                    Gratis
                </span>
            </label>
        </div> --}}

        <div>
            <x-jet-button wire:loading.attr="disabled" wire:target="create_order" class="mt-6 mb-4"
                wire:click="create_order">
                Solicitar la compra
            </x-jet-button>

            <hr>

            <p class="text-sm text-gray-700 mt-2">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Totam atque
                quo, labore facere placeat illo consequatur hic ut sapiente exercitationem, architecto iure,
                consequuntur impedit ex iusto ipsa voluptas laudantium iste <a href=""
                    class="font-semibold text-orange-500">Políticas y privacidad</a></p>
        </div>

    </div>

    <div class="order-1 lg:order-2 lg:col-span-1 xl:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <ul>
                @forelse (Cart::content() as $item)
                    <li class="flex p-2 border-b border-gray-200">
                        <img class="h-15 w-20 object-cover mr-4" src="{{ $item->options->image }}" alt="">

                        <article class="flex-1">
                            <h1 class="font-bold">{{ $item->name }}</h1>

                            <div class="flex">
                                <p>Cant: {{ $item->qty }}</p>
                                @isset($item->options['color'])
                                    <p class="mx-2">- Color: {{ __($item->options['color']) }}</p>
                                @endisset

                                @isset($item->options['size'])
                                    <p>{{ $item->options['size'] }}</p>
                                @endisset

                            </div>

                            <p>USD {{ $item->price }}</p>
                        </article>
                    </li>
                @empty
                    <li class="py-6 px-4">
                        <p class="text-center text-gray-700">
                            No tiene agregado ningún item en el carrito
                        </p>
                    </li>
                @endforelse
            </ul>

            <hr class="mt-4 mb-3">

            <div class="text-gray-700">
                <p class="flex justify-between items-center">
                    Subtotal
                    <span class="font-semibold">{{ Cart::subtotal() }} USD</span>
                </p>
                <p class="flex justify-between items-center">
                    Envío
                    <span class="font-semibold">
                        @if ($envio_type == 1 || $shipping_cost == 0)
                            Disponible
                        @else
                            No disponible
                        @endif
                    </span>
                </p>

                <hr class="mt-4 mb-3">

                <p class="flex justify-between items-center font-semibold">
                    <span class="text-lg">Total</span>
                    @if ($envio_type == 1)
                        {{ Cart::subtotal() }} USD
                    @else
                        {{ Cart::subtotal() + $shipping_cost }} USD
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
