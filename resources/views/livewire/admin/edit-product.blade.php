<div>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                    Productos
                </h1>

                <x-jet-danger-button wire:click="$emit('deleteProduct')">
                    Eliminar
                </x-jet-danger-button>
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-700">

        <h1 class="text-3xl text-center font-semibold mb-8">Complete esta información para crear un producto</h1>

        <div class="mb-4" wire:ignore>
            <form action="{{ route('admin.products.files', $product) }}" method="POST" class="dropzone"
                id="my-awesome-dropzone"></form>
        </div>

        @if ($product->images->count())

            <section class="bg-white shadow-xl rounded-lg p-6 mb-4">
                <h1 class="text-2xl text-center font-semibold mb-2">Imagenes del producto</h1>

                <ul class="flex flex-wrap">
                    @foreach ($product->images as $image)

                        <li class="relative" wire:key="image-{{ $image->id }}">
                            <img class="w-32 h-20 object-cover" src="{{ asset($image->url) }}" alt="">
                            <x-jet-danger-button class="absolute right-2 top-2"
                                wire:click="deleteImage({{ $image->id }})" wire:loading.attr="disabled"
                                wire:target="deleteImage({{ $image->id }})">
                                x
                            </x-jet-danger-button>
                        </li>

                    @endforeach

                </ul>
            </section>

        @endif

        @role('admin')
            @livewire('admin.status-product', ['product' => $product], key('status-product-' . $product->id))
        @endrole

        {{-- <div class="bg-white shadow-xl rounded-lg p-6">

        </div> --}}

        <div class="bg-white shadow-xl rounded-lg p-6">
            <div class="grid grid-cols-2 gap-6 mb-4">

                {{-- Categoría --}}
                <div>
                    <x-jet-label value="Categorías*" />
                    <select class="w-full form-control" wire:model="product.category_id">
                        <option value="" selected disabled>Seleccione una categoría</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <x-jet-input-error for="product.category_id" />
                </div>

                {{-- Subcategoría --}}
                <div>
                    <x-jet-label value="Subcategorías*" />
                    <select class="w-full form-control" wire:model="product.subcategory_id">
                        <option value="" selected disabled>Seleccione una subcategoría</option>

                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                        @endforeach
                    </select>

                    <x-jet-input-error for="product.subcategory_id" />
                </div>
            </div>

            {{-- Nombre --}}
            <div class="mb-4">
                <x-jet-label value="Nombre*" />
                <x-jet-input type="text" class="w-full" wire:model="product.name"
                    placeholder="Ingrese el nombre del producto" />
                <x-jet-input-error for="product.name" />
            </div>

            {{-- Slug --}}
            <div class="mb-4 hidden">
                <x-jet-label value="Slug" />
                <x-jet-input type="text" disabled wire:model="slug" class="w-full bg-gray-200"
                    placeholder="Ingrese el slug del producto" />

                <x-jet-input-error for="slug" />
            </div>

            <div class="grid grid-cols-2 gap-6 mb-4">

                {{-- Modelo --}}
                <div>
                    <x-jet-label value="Modelo*" />
                    <x-jet-input type="text" class="w-full" wire:model="product.model"
                        placeholder="Ingrese el modelo del producto" />
                    <x-jet-input-error for="product.model" />
                </div>

                {{-- Numero de serie --}}
                <div>
                    <x-jet-label value="No. Serie" />
                    <x-jet-input type="text" class="w-full" wire:model="product.serie_number"
                        placeholder="Ingrese el no. de serie del producto" />
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6 mb-4">
                {{-- Precio --}}
                <div>
                    <x-jet-label value="Precio de venta en Saldo HVAC*" />
                    <x-jet-input wire:model="product.price" type="number" class="w-full" step=".01" />
                    <x-jet-input-error for="product.price" />
                </div>

                {{-- Precio commercial --}}
                <div>
                    <x-jet-label value="Precio comercial*" />
                    <x-jet-input wire:model="product.commercial_price" type="number" class="w-full"
                        step=".01" />
                    <x-jet-input-error for="product.commercial_price" />
                </div>
                {{-- moneda --}}
                <div>
                    <x-jet-label value="Moneda*" />
                    <select class="w-full form-control" wire:model="product.currency_id">
                        <option value="" selected disabled>Seleccione una moneda</option>

                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}">{{ $currency->currency .  $currency->symbol}}</option>
                        @endforeach
                    </select>

                    <x-jet-input-error for="product.currency_id" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-4">
                {{-- cantidad --}}
                <div class="mb-4">
                    <x-jet-label value="Cantidad*" />
                    <x-jet-input wire:model="product.quantity" type="number" class="w-full" />
                    <x-jet-input-error for="product.quantity" />
                </div>
                {{-- unidad --}}
                <div>
                    <x-jet-label value="Unidad*" />
                    <x-jet-input wire:model="product.unit" type="text" class="w-full" placeholder="pza, paquete, caja, etc."/>
                    <x-jet-input-error for="product.unit" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-4">
                {{-- Marca --}}
                <div>
                    <x-jet-label value="Marca*" />
                    <select class="form-control w-full" wire:model="product.brand_id">
                        <option value="" selected disabled>Seleccione una marca</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>

                    <x-jet-input-error for="product.brand_id" />
                </div>

                {{-- Envio disponible --}}
                <div>
                    <x-jet-label value="Envio disponible*" />
                    <select class="form-control w-full" wire:model="product.shipping">
                        <option value="0">No</option>
                        <option value="1">Si</option>
                    </select>

                    <x-jet-input-error for="product.shipping" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-4">
                {{-- Pais / estado --}}
                <div>
                    <x-jet-label value="Selecciona un estado ({{ $user->country->name }})*" />
                    <select class="form-control w-full" wire:model="product.state_id">
                        <option value="" selected disabled>Seleccione un estado</option>
                        @foreach ($user->country->states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>

                    {{-- <x-jet-input-error for="country_id" /> --}}
                </div>
                {{-- ciudad --}}
                <div>
                    <x-jet-label value="Ciudad/Localidad*" />
                    <x-jet-input type="text" class="w-full" wire:model="product.city"
                        placeholder="Nombre completo" />
                    <x-jet-input-error for="product.city" />
                </div>
            </div>

            <div class="grid grid-cols-4 gap-6 mb-4">
                {{-- Descrición --}}
                <div class="mb-4 col-span-3">
                    <div wire:ignore>
                        <x-jet-label value="Descripción*" />
                        <textarea class="w-full form-control" rows="4" wire:model="product.description" x-data>
                    </textarea>
                    </div>
                    <x-jet-input-error for="product.description" />
                </div>
                <div class="mt-4">
                    <img src="https://chart.googleapis.com/chart?cht=qr&chl={{ $product->id }}&chs=120x120&chld=L|0"
                        class="qr-code img-thumbnail img-responsive mx-auto" />

                </div>

            </div>
            <div class="flex justify-end items-center mt-4">

                <x-jet-action-message class="mr-3" on="saved">
                    Actualizado
                </x-jet-action-message>

                <x-jet-button wire:loading.attr="disabled" wire:target="save" wire:click="save">
                    Actualizar producto
                </x-jet-button>
            </div>
        </div>


        @if ($this->subcategory)

            @if ($this->subcategory->size)

                @livewire('admin.size-product', ['product' => $product], key('size-product-' . $product->id))

            @elseif($this->subcategory->color)

                @livewire('admin.color-product', ['product' => $product], key('color-product-' . $product->id))

            @endif

        @endif


    </div>


    @push('script')
        <script>
            Dropzone.options.myAwesomeDropzone = {
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                dictDefaultMessage: "Arrastre una imagen al recuadro",
                acceptedFiles: 'image/*',
                paramName: "file", // The name that will be used to transfer the file
                maxFilesize: 2, // MB
                complete: function(file) {
                    this.removeFile(file);
                },
                queuecomplete: function() {
                    Livewire.emit('refreshProduct');
                }
            };


            Livewire.on('deleteProduct', () => {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('admin.edit-product', 'delete');

                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })

            })

            Livewire.on('deleteSize', sizeId => {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('admin.size-product', 'delete', sizeId);

                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })

            })

            Livewire.on('deletePivot', pivot => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('admin.color-product', 'delete', pivot);

                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            })

            Livewire.on('deleteColorSize', pivot => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('admin.color-size', 'delete', pivot);

                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            })
        </script>
    @endpush

</div>
