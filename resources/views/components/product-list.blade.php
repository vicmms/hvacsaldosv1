@props(['product'])

<li class="bg-white rounded-lg shadow mb-4">
    <article class="md:flex">
        <figure>
            <img class="h-48 w-full md:w-56 object-cover object-center"
                src="{{ count($product->images) ? asset($product->images->first()->url) : asset('/images/image-not-found.png') }}"
                alt="">
        </figure>

        <div class="flex-1 py-4 px-6 flex flex-col">
            <div class="lg:flex justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-700">{{ $product->name }}</h1>
                    <p class="font-bold text-gray-700">
                        {{ $product->currency ? $product->currency->currency : '' }}
                                        {{ $product->currency ? $product->currency->symbol : '$' }}{{ number_format($product->price, 0, '.', ',') }}
                    </p>
                    <p class="font-bold text-gray-700">
                        Stock: {{$product->quantity}}
                    </p>
                    <p class="font-bold text-gray-700">
                        <i class="fas fa-map-marker-alt"></i> {{$product->state->name}}
                    </p>
                </div>

                <div class="flex ">
                    {{-- <span class="text-gray-700 text-sm"><i class="fas fa-map-marker-alt"></i> {{$product->state->name}}</span> --}}
                </div>
            </div>

            <div class="mt-4 md:mt-auto mb-4">
                <x-danger-enlace href="{{ route('products.show', $product) }}">
                    Ver producto
                </x-danger-enlace>
            </div>
        </div>
    </article>
</li>
