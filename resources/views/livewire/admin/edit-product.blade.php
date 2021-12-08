<div>
    <style>
        .cover-image {
            height: 550px !important;
            object-fit: contain;
        }

        .flex-direction-nav a {
            overflow: unset !important;
        }

    </style>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                    Productos
                </h1>

                <x-jet-danger-button wire:click="$emit('deleteProduct', {{ $product }})">
                    Eliminar
                </x-jet-danger-button>
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-700">

        <h1 class="text-3xl text-center font-semibold mb-8">Complete esta información para crear un producto</h1>

        <div class="mb-4 {{ $product->status == 2 ? 'disabled' : '' }}">
            <form wire:ignore action="{{ route('admin.products.files', $product) }}" method="POST"
                class="dropzone" id="my-awesome-dropzone"></form>
        </div>

        @if ($product->images->count() || $product->videos->count())

            <section class="bg-white shadow-xl rounded-lg p-6 mb-4">
                <h1 class="text-2xl text-center font-semibold mb-2">Imagenes del producto</h1>

                <ul class="flex flex-wrap {{ $product->status == 2 ? 'disabled' : '' }}" id="images_list">
                    @if ($product->images->count())
                        @foreach ($product->images as $image)

                            <li class="relative mr-1" wire:key="image-{{ $image->id }}">
                                <img class="w-32 h-20 object-cover rounded-md" src="{{ asset($image->url) }}" alt="">
                                <button class="absolute right-2 top-2 bg-red-500 text-white rounded-full px-2"
                                    wire:click="deleteImage({{ $image->id }})" wire:loading.attr="disabled"
                                    wire:target="deleteImage({{ $image->id }})">
                                    x
                                </button>
                            </li>
                        @endforeach
                    @endif
                    @if ($product->videos->count())
                        <li class="relative mr-1" wire:key="image-{{ $product->videos->first()->id }}">
                            <img class="w-32 h-20 object-cover" src="{{ asset('images/video.png') }}" alt="">
                            <button class="absolute right-2 top-2 bg-red-500 text-white rounded-full px-2"
                                wire:click="deleteVideo({{ $product->videos->first()->id }})"
                                wire:loading.attr="disabled"
                                wire:target="deleteVideo({{ $product->videos->first()->id }})">
                                x
                            </button>
                        </li>
                    @endif
                </ul>
                <x-jet-danger-button wire:click="modalImages()" class="mt-6">
                    <i class="fas fa-search-plus mr-1"></i>Ver imagenes
                </x-jet-danger-button>
            </section>


            <x-jet-dialog-modal wire:model.lazy="modalImages">

                <x-slot name="title">
                    <span class="font-bold text-2xl">{{ $product->name }}</span>
                </x-slot>

                <x-slot name="content">
                    <div class="space-y-3 fs" wire:ignore>
                        {{-- se llena desde js --}}
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <x-jet-danger-button wire:click="modalImages">
                        cerrar
                    </x-jet-danger-button>
                </x-slot>

            </x-jet-dialog-modal>

        @endif

        @role('admin|user')
            @livewire('admin.status-product', ['product' => $product], key('status-product-' . $product->id))
        @endrole
        @if ($isRejected)
            @livewire('admin.rejection-record', ['rejections' => $product->rejections])
        @endif

        {{-- <div class="bg-white shadow-xl rounded-lg p-6">

        </div> --}}

        <div class="bg-white shadow-xl rounded-lg p-6">
            @switch($product->status)
                @case(1)
                    <span
                        class="mb-4 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        En revisión
                    </span>
                @break
                @case(2)
                    <span
                        class="mb-4 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Publicado
                    </span>
                @break
                @case(3)
                    <span
                        class="mb-4 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        Rechazado
                    </span>
                @break
                @case(4)
                    <span
                        class="mb-4 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800">
                        Sin publicar
                    </span>
                @break
                @default

            @endswitch
            <div class="grid grid-cols-2 gap-6 mb-4 {{ $product->status == 2 ? 'disabled' : '' }}">

                {{-- Categoría --}}
                <div>
                    <x-jet-label value="Categorías*" />
                    <select class="w-full form-control" wire:model.lazy="product.category_id">
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
                    <select class="w-full form-control" wire:model.lazy="product.subcategory_id">
                        <option value="" selected disabled>Seleccione una subcategoría</option>

                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                        @endforeach
                    </select>

                    <x-jet-input-error for="product.subcategory_id" />
                </div>
            </div>

            {{-- Nombre --}}
            <div class="mb-4 {{ $product->status == 2 ? 'disabled' : '' }}">
                <x-jet-label value="Nombre*" />
                <x-jet-input wire:ignore type="text" class="w-full" wire:model.lazy="product.name"
                    placeholder="Ingrese el nombre del producto" />
                <x-jet-input-error for="product.name" />
            </div>

            {{-- Slug --}}
            <div class="mb-4 hidden">
                <x-jet-label value="Slug" />
                <x-jet-input type="text" disabled wire:model.lazy="slug" class="w-full bg-gray-200"
                    placeholder="Ingrese el slug del producto" />

                <x-jet-input-error for="slug" />
            </div>

            <div class="grid grid-cols-3 gap-6 mb-4 {{ $product->status == 2 ? 'disabled' : '' }}">

                {{-- Marca --}}
                <div>
                    <x-jet-label value="Marca*" />
                    <select class="form-control w-full" wire:model.lazy="product.brand_id">
                        <option value="" selected disabled>Seleccione una marca</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>

                    <x-jet-input-error for="product.brand_id" />
                </div>

                {{-- Modelo --}}
                <div>
                    <x-jet-label value="Modelo*" />
                    <x-jet-input type="text" class="w-full" wire:model.lazy="product.model"
                        placeholder="Ingrese el modelo del producto" />
                    <x-jet-input-error for="product.model" />
                </div>

                {{-- Numero de serie --}}
                <div>
                    <x-jet-label value="No. Serie" />
                    <x-jet-input type="text" class="w-full" wire:model.lazy="serie_number"
                        placeholder="Ingrese el no. de serie del producto" />
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6 mb-4 {{ $product->status == 2 ? 'disabled' : '' }}">
                {{-- Precio --}}
                <div>
                    <x-jet-label value="Precio de venta en Saldo HVAC (iva incluido)*" />
                    <x-jet-input wire:model.lazy="product.price" type="text" class="w-full formatter" step="1"
                        onkeyup="formatter(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                    <x-jet-input-error for="product.price" />
                </div>

                {{-- Precio commercial --}}
                <div>
                    <x-jet-label value="Precio comercial (iva incluido)*" />
                    <x-jet-input wire:model.lazy="product.commercial_price" type="text" class="w-full formatter"
                        onkeyup="formatter(this)" step="1"
                        onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" />
                    <x-jet-input-error for="product.commercial_price" />
                </div>
                {{-- moneda --}}
                <div>
                    <x-jet-label value="Moneda*" />
                    <select class="w-full form-control" wire:model.lazy="product.currency_id">
                        <option value="" selected disabled>Seleccione una moneda</option>

                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}">{{ $currency->currency . $currency->symbol }}
                            </option>
                        @endforeach
                    </select>

                    <x-jet-input-error for="product.currency_id" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-4">
                {{-- cantidad --}}
                <div class="">
                    <x-jet-label value="Cantidad*" />
                    <x-jet-input wire:model.lazy="product.quantity" type="number" class="w-full" />
                    <x-jet-input-error for="product.quantity" />
                </div>
                {{-- unidad --}}
                <div class="{{ $product->status == 2 ? 'disabled' : '' }}">
                    <x-jet-label value="Unidad*" />
                    <x-jet-input wire:model.lazy="product.unit" type="text" class="w-full"
                        placeholder="pza, paquete, caja, etc." />
                    <x-jet-input-error for="product.unit" />
                </div>
            </div>

            <div class="mb-4 {{ $product->status == 2 ? 'disabled' : '' }}">

                {{-- Envio disponible --}}

                <x-jet-label value="Envio disponible*" />
                <div class="flex my-2">
                    <x-jet-label class="mr-4 text-base">
                        <x-jet-checkbox wire:model.defer="product.shipping" name="types[]" value="1" />Envío a cargo del
                        comprador
                    </x-jet-label>
                    <x-jet-label class="mr-4 text-base">
                        <x-jet-checkbox wire:model.defer="product.shipping" name="types[]" value="2" />Recolección en
                        oficinas del vendedor
                    </x-jet-label>
                    <x-jet-label class=" text-base">
                        <x-jet-checkbox wire:model.defer="product.shipping" name="types[]" value="3" />Entrega sin costo
                        dentro de la ciudad
                    </x-jet-label>
                </div>

                <x-jet-input-error for="product.shipping" />
            </div>

            <div class="grid grid-cols-2 gap-6 mb-4 {{ $product->status == 2 ? 'disabled' : '' }}">
                {{-- Pais / estado --}}
                <div>
                    <x-jet-label value="Selecciona un estado ({{ $user->country->name }})*" />
                    <select class="form-control w-full" wire:model.lazy="product.state_id">
                        <option value="0" selected disabled>Seleccione un estado</option>
                        @foreach ($user->country->states()->orderBy('name', 'asc')->get() as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>

                    {{-- <x-jet-input-error for="country_id" /> --}}
                </div>
                {{-- ciudad --}}
                <div>
                    <x-jet-label value="Ciudad/Localidad*" />
                    <x-jet-input type="text" class="w-full" wire:model.lazy="product.city"
                        placeholder="Nombre completo" />
                    <x-jet-input-error for="product.city" />
                </div>
            </div>

            <div class="grid grid-cols-4 gap-6 mb-4 ">
                {{-- Descrición --}}
                <div class="mb-4 col-span-3 {{ $product->status == 2 ? 'disabled' : '' }}">
                    <div wire:ignore>
                        <x-jet-label value="Descripción*" />
                        <textarea class="w-full form-control" rows="4" wire:model.lazy="product.description" x-data>
                    </textarea>
                    </div>
                    <x-jet-input-error for="product.description" />
                </div>
                <div class="mt-4 text-center">
                    <a class="hover:text-orange-400" href="{{ route('imprimirQr', $product) }}" target="_blank">
                        <img src="https://chart.googleapis.com/chart?cht=qr&chl={{ $product->id }}&chs=120x120&chld=L|0"
                            class="qr-code img-thumbnail img-responsive mx-auto" />
                        Imprimir
                    </a>
                </div>

            </div>
            @if ($product->status == 2)
                <p class="text-sm italic text-gray-600 my-6">Actualmente este producto se encuentra publicado en Saldo
                    HVAC, puede cambiar el stock disponible del producto si lo desea, o bien para cambiar la información
                    del producto es necesario retirarlo primero de la plataforma.</p>
            @endif
            <div class="flex justify-end items-center mt-4">

                <x-jet-action-message class="mr-3" on="saved">
                    Actualizado
                </x-jet-action-message>

                @if ($isRejected)
                    <x-jet-danger-button class="mr-4" wire:loading.attr="disabled" wire:target="save(true)"
                        wire:click="save(true)">
                        Actualizar y enviar a revisión
                    </x-jet-danger-button>
                @endif

                @if ($isNew)
                    <x-jet-danger-button class="mr-4" wire:loading.attr="disabled" wire:target="save(true)"
                        wire:click="save(true)">
                        Actualizar y Publicar
                    </x-jet-danger-button>
                @endif

                @if ($product->status == 2)
                    <x-jet-danger-button class="mr-4" wire:loading.attr="disabled" wire:target="removeProduct"
                        wire:click="removeProduct">
                        Quitar de saldos
                    </x-jet-danger-button>
                @endif

                <x-jet-button wire:loading.attr="disabled" wire:target="save" wire:click="save">
                    Actualizar
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
            var errorMessage;
            Dropzone.options.myAwesomeDropzone = {
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                dictDefaultMessage: "Da clic o arrastra imagenes al recuadro, máximo 4.",
                acceptedFiles: 'image/jpg, image/png, image/jpeg', //, video/mp4
                paramName: "file", // The name that will be used to transfer the file
                maxFilesize: 5, // MB
                init: function() {
                    this.on("addedfiles", function(listFiles) {
                        errorMessage = false;
                        currentImages = document.getElementById("images_list") ? document.getElementById(
                            "images_list").getElementsByTagName("li").length : 0;
                        contImages = Object.keys(listFiles).length;
                        isMaxImages = currentImages + contImages > 4 ? true : false;
                        Livewire.emit('refreshProduct', isMaxImages);
                    });
                    this.on("error", function(file, message) {
                        if (!errorMessage) {
                            message = message['message'] ? message['errors']['file'][0] : message;
                            Swal.fire({
                                icon: 'warning',
                                title: message,
                                showConfirmButton: true,
                            })
                        }
                        errorMessage = true;
                    });
                },
                complete: function(file) {
                    this.removeFile(file);
                },
                queuecomplete: function() {
                    Livewire.emit('refreshProduct');
                }
            };

            Livewire.on('maxFiles', () => {
                Swal.fire({
                    icon: 'warning',
                    text: 'Se pueden subir como máximo 4 fotos y un video',
                    title: 'No se cargaron todos los archivos',
                    showConfirmButton: true,
                })
            })


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

                        Livewire.emitTo('admin.edit-product', 'delete');

                        Swal.fire({
                            title: 'Realizado!',
                            text: 'Producto eliminado exitosamente',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1000,
                        })
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

            Livewire.on('showModalImages', (images) => {
                $('.slides').empty();
                $('.fs').empty();
                $('.fs').append(
                    `
                    <div class="flexslider" wire:ignore>
                            <ul class="slides">

                            </ul>
                        </div>
                    `
                );
                images.forEach(image => {
                    $('.slides').append('<li><img src="/' + image['url'] + '" class="cover-image"></li>');
                });
                $('.flexslider').flexslider();
                $('.flex-next').text('');
                $('.flex-prev').text('');
            });

            Livewire.on('company_info', () => {
                Swal.fire({
                    icon: 'warning',
                    text: 'Para publicar articulos en venta debes llenar correctamente la información de tu empresa (nombre y datos fiscales)',
                    title: 'Información requerida',
                    confirmButtonText: '<a href="/user/profile">Actualizar información</a>',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar'
                })
            })
            Livewire.on('images', () => {
                Swal.fire({
                    icon: 'warning',
                    text: 'Agrega imágenes del producto, puedes agregar hasta 4 imágenes.',
                    title: 'Faltan imágenes',
                    confirmButtonText: 'Ok',
                })
            })
        </script>
    @endpush

</div>
