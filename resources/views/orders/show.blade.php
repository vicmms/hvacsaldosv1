<x-app-layout>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">


        @if ($order->status != 5)
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

                <div
                    class="{{ $order->status >= 3 && $order->status != 5 ? 'bg-blue-400' : 'bg-gray-400' }} h-1 flex-1 mx-2">
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

                <div
                    class="{{ $order->status >= 4 && $order->status != 5 ? 'bg-blue-400' : 'bg-gray-400' }} h-1 flex-1 mx-2">
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
        @else
            <div class="bg-white rounded-lg shadow-lg px-12 py-8 mb-6 flex items-center">
                <div class="relative flex">
                    <div class="bg-red-400 rounded-full h-12 w-12 flex items-center justify-center">
                        <i class="fas fa-times text-white"></i>
                    </div>

                    <div class="self-center">
                        <p class="ml-4 text-gray-700 font-semibold text-lg">Orden cancelada</p>
                        <p class="ml-4 text-gray-600 text-md">{{ $comments }}</p>
                    </div>
                </div>
            </div>
        @endif





        <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6 flex items-center">
            <p class="text-gray-700 uppercase"><span class="font-semibold">Número de orden:</span>
                Orden-{{ $order->id }}</p>

            @if ($order->status == 1)

                <x-button-enlace class="ml-auto" href="{{ route('orders.payment', $order) }}">
                    Ir a pagar
                </x-button-enlace>

            @endif
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 text-gray-700 mb-6">
            <div class="flex">
                <p class="flex-1 text-xl font-semibold mb-4">Resumen</p>
                <a class="self-stretch text-lg" href="{{ route('orders.index') }}">
                    <i class="fas fa-arrow-left text-lg"></i> Regresar
                </a>
            </div>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th></th>
                        <th>Precio</th>
                        <th>Cant</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    <tr>
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
                            {{ json_decode($order->content)->options->currency ? json_decode($order->content)->options->currency : '$' }}
                            {{ number_format($items->price, 0, '.', ',') }}
                        </td>

                        <td class="text-center">
                            {{ $items->qty }}
                        </td>

                        <td class="text-center">
                            {{ json_decode($order->content)->options->currency ? json_decode($order->content)->options->currency : '$' }}
                            {{ number_format($items->price * $items->qty, 0, '.', ',') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>



    </div>

</x-app-layout>
