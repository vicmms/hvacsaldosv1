<div>
    <style>
        .wrapper{height: 50px;}
    </style>
    <div class="bg-white rounded-lg shadow-lg mb-6">
        <div class="px-6 py-2 flex justify-between items-center">
            @if ($seller)
                <h1 class="font-semibold text-gray-700 uppercase">Mostrando todos los productos del vendedor</h1>
            @else
                <h1 class="font-semibold text-gray-700 uppercase">{!! $category == 'all' ? 'Todos los productos' : ($category == 'offers' ? '<i class="fas fa-fire-alt"></i> Ofertas' : $category->name) !!}</h1>
            @endif
            <div class="hidden md:block grid grid-cols-2 border border-gray-200 divide-x divide-gray-200 text-gray-500">
                <i class="fas fa-border-all p-3 cursor-pointer {{ $view == 'grid' ? 'text-orange-500' : '' }}"
                    wire:click="$set('view', 'grid')"></i>
                <i class="fas fa-th-list p-3 cursor-pointer {{ $view == 'list' ? 'text-orange-500' : '' }}"
                    wire:click="$set('view', 'list')"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">

        <aside>

            <h2 class="font-semibold text-center mb-2">Subcategorías</h2>
            {{-- computadora --}}
            <ul class="divide-y divide-gray-200 hidden sm:block">
                <li class="py-2 text-sm">
                    <a class="cursor-pointer hover:text-orange-500 capitalize {{ !$subcategoria ? 'text-orange-500 font-semibold' : '' }}"
                        wire:click="limpiarSubcategories">Todas
                    </a>
                </li>
                @foreach ($subcategories as $subcategory)
                    <li class="py-2 text-sm">
                        <a class="cursor-pointer hover:text-orange-500 capitalize {{ $subcategoria == $subcategory->slug ? 'text-orange-500 font-semibold' : '' }}"
                            wire:click="$set('subcategoria', '{{ $subcategory->slug }}')">{{ $subcategory->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
            {{-- movil --}}
            <div class="w-full text-center">
                <select class="sm:hidden form-control w-80" wire:model="subcategoria">
                    <option value="">Todas</option>
                    @foreach ($subcategories as $subcategory)
                        <option class="py-2 text-sm"value="{{ $subcategory->slug }}">
                            {{ $subcategory->name }}
                        </option>
                    @endforeach
                <select>
            </div>

            <h2 class="font-semibold text-center mt-4 mb-2">Marcas</h2>
            {{-- computadora --}}
            <ul class="divide-y divide-gray-200 max-h-96 overflow-y-scroll hidden md:block">
                <li class="py-2 text-sm">
                    <a class="cursor-pointer hover:text-orange-500 capitalize {{ !$marca ? 'text-orange-500 font-semibold' : '' }}"
                        wire:click="limpiarBrands">
                        Todas
                    </a>
                </li>
                @foreach ($brands as $brand)
                    <li class="py-2 text-sm">
                        <a class="cursor-pointer hover:text-orange-500 capitalize {{ $marca == $brand->name ? 'text-orange-500 font-semibold' : '' }}"
                            wire:click="$set('marca', '{{ $brand->name }}')">
                            {{ $brand->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
            {{-- movil --}}
            <div class="w-full text-center wrapper">
                <select class="sm:hidden form-control w-80" wire:model="marca" onfocus='this.size=7;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                    <option value="">Todas </option>
                    @foreach ($brands as $brand)
                        <option class="py-2 text-sm" value="{{ $brand->name }}">
                            {{ $brand->name }}
                        </option>
                    @endforeach
                <select>
            </div>

            <div class="w-full text-center">
                <x-jet-button class="mt-4" wire:click="limpiar">
                    Eliminar filtros
                </x-jet-button>
            </div>
        </aside>

        <div class="md:col-span-2 lg:col-span-4">
            @if ($view == 'grid')

                <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse ($products as $product)
                        <li class="bg-white rounded-lg shadow">
                            <article>
                                <figure>
                                    <img class="h-48 w-full object-cover object-center"
                                        src="{{ count($product->images) ? asset($product->images->first()->url) : asset('/images/image-not-found.png') }}"
                                        alt="">
                                </figure>

                                <div class="py-4 px-4">
                                    <h1 class="text-lg font-semibold">
                                        <a href="{{ route('products.show', $product) }}">
                                            @if ($product->isOffer)
                                                <i class="fas fa-fire-alt text-red-500"> </i>
                                            @endif
                                            {{ Str::limit($product->name, 15) }}
                                        </a>
                                    </h1>
                                    <del class="text-red-800 font-bold text-sm">
                                        {{ $product->currency ? $product->currency->currency : '' }}
                                        {{ $product->currency ? $product->currency->symbol : '$' }}{{ number_format($product->commercial_price, 0, '.', ',') }}
                                    </del>
                                    <p class="font-bold text-trueGray-700">
                                        {{ $product->currency ? $product->currency->currency : '' }}
                                        {{ $product->currency ? $product->currency->symbol : '$' }}{{ number_format($product->price, 0, '.', ',') }}
                                    </p>
                                </div>
                            </article>
                        </li>

                    @empty
                        <li class="md:col-span-2 lg:col-span-4">
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                                role="alert">
                                <strong class="font-bold"></strong>
                                <span class="block sm:inline">No se encontraron productos</span>
                            </div>
                        </li>
                    @endforelse
                </ul>

            @else
                <ul>
                    @forelse ($products as $product)

                        <x-product-list :product="$product" />

                    @empty

                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded md:relative"
                            role="alert">
                            <strong class="font-bold">Upss!</strong>
                            <span class="block sm:inline">No se han encontrado productos.</span>
                        </div>

                    @endforelse
                </ul>
            @endif

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>

    </div>
</div>
