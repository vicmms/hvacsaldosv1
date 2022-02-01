<div>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                Lista de productos
            </h2>

            <x-button-enlace class="ml-auto" href="{{ route('admin.products.create') }}">
                Agregar producto
            </x-button-enlace>
        </div>
    </x-slot>


    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="container py-12">

        <div class="px-6 py-4 grid md:grid-cols-4">
            <div class="flex mb-4 md:mb-0">
                <h2 class="self-center font-semibold mr-2">Status: </h2>
                <select name="" id="" class="form-control" wire:model.lazy="status">
                    <option value="0" selected wire:key="0">Todos</option>
                    <option value="1" wire:key="1">En revisión</option>
                    <option value="2" wire:key="2">Aceptados</option>
                    <option value="3" wire:key="3">Rechazados</option>
                </select>
            </div>
            <div class="col-span-3">
                <x-jet-input type="text" wire:model="search" class="w-full" placeholder="Buscar..." />
            </div>
        </div>

        <x-table-responsive>

            @if ($products->count())

                <table class="min-w-full divide-y divide-gray-200" id="showProducts">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="md:hidden px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Categoría
                            </th>

                            @role('admin')
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Vendedor
                                </th>
                            @endrole

                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Precio
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha
                            </th>
                            <th scope="col"
                                class="hidden md:block px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">

                        @foreach ($products as $product)
                            <tr>
                                <td class="md:hidden px-4 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="text-gray-400 hover:text-indigo-600"><i class="fas fa-pen"></i></a>
                                    <i class="fas fa-trash text-red-400 hover:text-red-600 ml-2 cursor-pointer"
                                        wire:click="$emit('deleteProduct', {{ $product }})"></i>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if ($product->images->count())
                                                <img class="h-10 w-10 rounded-full object-cover"
                                                    src="{{ asset($product->images->first()->url) }}" alt="">
                                            @else
                                                <img class="h-10 w-10 rounded-full object-cover"
                                                    src="{{ asset('./images/image-not-found.png') }}" alt="">
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ Str::limit($product->name, 30) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">

                                    <div class="text-sm text-gray-900">

                                        {{ Str::limit($product->category->name, 20) }}
                                    </div>

                                </td>

                                @role('admin')
                                    <td class="px-4 py-4 whitespace-nowrap">

                                        <div class="text-sm text-gray-900">
                                            {{ Str::limit($product->user->name, 20) }}
                                        </div>

                                    </td>
                                @endrole

                                <td class="px-4 py-4 whitespace-nowrap">
                                    @switch($product->status)
                                        @case(1)
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                En revisión
                                            </span>
                                        @break
                                        @case(2)
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Aceptado
                                            </span>
                                        @break
                                        @case(3)
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Rechazado
                                            </span>
                                        @break
                                        @case(4)
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800">
                                                Sin publicar
                                            </span>
                                        @break
                                        @default

                                    @endswitch

                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $product->currency ? $product->currency->currency : '' }}
                                    {{ $product->currency ? $product->currency->symbol : '$' }}
                                    {{ number_format($product->price, 0, '.', ',') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ explode(' ', $product->created_at)[0] }}
                                </td>
                                <td class="hidden md:block px-4 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="text-gray-400 hover:text-indigo-600"><i class="fas fa-pen"></i></a>
                                    <i class="fas fa-trash text-red-400 hover:text-red-600 ml-2 cursor-pointer"
                                        wire:click="$emit('deleteProduct', {{ $product }})"></i>
                                </td>
                            </tr>

                        @endforeach
                        <!-- More people... -->
                    </tbody>
                </table>

            @else
                <div class="px-6 py-4">
                    No hay ningún registro coincidente
                </div>
            @endif

            @if ($products->hasPages())

                <div class="px-6 py-4">
                    {{ $products->links() }}
                </div>

            @endif


        </x-table-responsive>
    </div>
    @push('script')
        <script>
            Livewire.on('deleteProduct', (product) => {
                Swal.fire({
                    title: '¿Eliminar ' + product['name'] + '?',
                    text: "Se perderá toda la información relacionada con este producto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Eliminar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('admin.show-products', 'delete', product['id']);

                        Swal.fire({
                            title: 'Realizado!',
                            text: 'Producto eliminado exitosamente',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1000,
                        })
                    }
                })

            });
        </script>
    @endpush

</div>
