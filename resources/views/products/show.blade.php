<x-app-layout>
    <div class="container py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
            <div>
                <div class="flexslider">
                    <ul class="slides">
                        @if(!count($product->images))
                        <li data-thumb=" {{ asset('images/image-not-found.png') }}">
                            <img src=" {{ asset('images/image-not-found.png') }}" />
                        </li>
                        @endif
                        @foreach ($product->images as $image)

                        <li data-thumb=" {{ asset($image->url) }}">
                            <img src=" {{ asset($image->url) }}" />
                        </li>

                        @endforeach

                    </ul>
                </div>

            </div>

            <div>
                <h1 class="text-3xl font-bold text-trueGray-700">{{ $product->name }}</h1>

                {{-- <div class="flex">
                    <p class="text-trueGray-700">Marca: <a class="underline capitalize hover:text-orange-500"
                            href="">{{ $product->brand->name }}</a></p>
                <p class="text-trueGray-700 mx-6">5 <i class="fas fa-star text-sm text-yellow-400"></i></p>
                <a class="text-orange-500 hover:text-orange-600 underline" href="">39 reseñas</a>
            </div> --}}
            <p class="text-trueGray-700 font-semibold">Categoría: <a class="capitalize hover:text-orange-500" href="">{{ $product->category->name }}</a></p>

            <p class="text-trueGray-700 font-semibold">Subcategoría: <a class="capitalize hover:text-orange-500" href="">{{ $product->subcategory->name }}</a></p>

            <p class="text-trueGray-700 font-semibold">Marca: <a class=" capitalize hover:text-orange-500" href="">{{ $product->brand->name }}</a></p>
            <p class="text-trueGray-700 font-semibold">Modelo: <a class=" capitalize hover:text-orange-500" href="">{{ $product->model }}</a></p>
            <p class="text-trueGray-700 font-semibold">No. Serie: <a class="capitalize hover:text-orange-500" href="">{{ $product->serie_number ? $product->serie_number : 'No especificado' }}</a></p>

            <p class="text-2xl font-semibold text-trueGray-700 my-4">Precio de Venta:
                {{ $product->state->country->currency }}
                {{ $product->state->country->denotation . $product->price }}
            </p>
            <p class="text-xl font-semibold  my-4">Precio Comercial:
                <del class="text-red-800">
                    {{ $product->state->country->currency }}
                    {{ $product->state->country->denotation . $product->commercial_price }}
                </del>
            </p>

            <p class="text-xl font-semibold  my-4">Ubicación:
                {{ $product->state->name }}
            </p>

            <div class="bg-white rounded-lg shadow-lg mb-6">
                <div class="p-4 flex items-center">
                    <span class="flex items-center justify-center h-10 w-10 rounded-full bg-greenLime-600">
                        <i class="fas fa-truck text-sm text-white"></i>
                    </span>

                    <div class="ml-4">
                        <p class="text-lg font-semibold text-greenLime-600">
                            {{ $product->shipping ? 'Envío disponible' : 'Sin envío disponible' }}
                        </p>
                        @if ($product->shipping)
                        <p>{{ $product->shipping_cost ? 'Costo de envío: ' . $product->shipping_cost : 'Sin costo extra' }}
                        </p>

                        @endif
                    </div>
                </div>
            </div>

            @if ($product->subcategory->size)

            @livewire('add-cart-item-size', ['product' => $product])

            @elseif($product->subcategory->color)

            @livewire('add-cart-item-color', ['product' => $product])

            @else

            @livewire('add-cart-item', ['product' => $product])

            @endif

            <div class="mt-6 text-gray-700">
                <h2 class="font-bold text-lg">Descripción</h2>
                <p class="bg-white p-4 rounded-lg shadow-lg">{!! $product->description !!}</p>
            </div>
        </div>
    </div>
    </div>

    @push('script')
    <script>
        $(document).ready(function() {
            $('.flexslider').flexslider({
                animation: "slide",
                controlNav: "thumbnails"
            });
        });
    </script>
    @endpush
</x-app-layout>