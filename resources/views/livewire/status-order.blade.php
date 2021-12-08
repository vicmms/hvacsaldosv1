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



    @if ($order->status != 5)
        @role('admin')
            <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6">
                <p class="text-gray-700 uppercase"><span class="font-semibold">Número de orden:</span>
                    Orden-{{ $order->id }}</p>

                {{-- <form wire:submit.prevent="update"> --}}
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
                    @if ($status != 5)
                        <x-jet-button class="mr-4" wire:click="update">
                            Actualizar
                        </x-jet-button>
                    @else
                        <x-jet-button class="mr-4" wire:click="$emit('cancel-order')" wire:loading.attr="disabled"
                            wire:target="changeModal">
                            Actualizar
                        </x-jet-button>
                    @endif
                </div>
                {{-- </form> --}}

                <x-jet-dialog-modal wire:model="isOpen">

                    <x-slot name="title">
                        Cancelar orden
                    </x-slot>

                    <x-slot name="content">

                        <div class="space-y-3">

                            <div>
                                <x-jet-label>
                                    Describe los motivos de la cancelación de la orden
                                </x-jet-label>

                                <textarea name="message" rows="5" wire:model="message"
                                    class="w-full mt-1 form-control"></textarea>

                                <x-jet-input-error for="message" />
                            </div>

                        </div>
                    </x-slot>

                    <x-slot name="footer">
                        <x-jet-button wire:click="changeModal">
                            Cerrar
                        </x-jet-button>
                        <x-jet-danger-button wire:click="cancel" wire:loading.attr="disabled" wire:target="cancel">
                            Cancelar Orden
                        </x-jet-danger-button>
                    </x-slot>

                </x-jet-dialog-modal>
            </div>
        @endrole
    @endif


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
            <p>Nombre: {{ $buyer ? $buyer->name : 'Sin datos' }}</p>
            <p>Correo: {{ $buyer ? $buyer->email : 'Sin datos' }}</p>
            <p>Empresa: {{ $buyer->company_info ? $buyer->company_info->name : 'Sin datos' }}</p>
            <p>Datos fiscales: </p>
            <p class="whitespace-pre-line ml-2">{{ $buyer->company_info ? $buyer->company_info->tax_data : 'Sin datos' }}</p>
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

    @push('script')
        <script>
            Livewire.on('cancel-order', () => {
                Swal.fire({
                    icon: 'warning',
                    text: 'Una vez cancelada ya no se podrá revertir su status y el producto será regresado a su stock',
                    title: '¿Realmente quieres cancelar esta orden?',
                    confirmButtonText: 'Continuar',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('status-order', 'changeModal');
                    }
                })
            })
        </script>
    @endpush

</div>
