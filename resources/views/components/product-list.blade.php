@props(['product'])

<div class="flex">
    <li
        class="bg-white rounded-lg shadow mb-4 flex-1 {{ Auth::check() ? (Auth::user()->email == 'yoliesglez@gmail.com' ? 'max-w-3xl' : '') : '' }}">
        <article class="md:flex ">
            <figure class="self-center ml-2 w-32" style="text-align: -webkit-center">
                <img class="{{ Auth::check() ? (Auth::user()->email == 'yoliesglez@gmail.com' ? 'h-24' : 'h-36 w-40') : '' }} rounded-sm  object-cover object-center"
                    src="{{ count($product->images) ? asset($product->images->first()->url) : asset('/images/image-not-found.png') }}"
                    alt="">
            </figure>

            <div class="flex-1 py-4 px-6 flex flex-col">
                <div class="lg:flex justify-between">
                    <div class="flex-1">
                        <h1 class="text-lg font-semibold text-gray-700">{!! $product->isOffer ? '<i class="fas fa-fire-alt text-red-500"></i>' : '' !!} {{ $product->name }}
                        </h1>
                        <del class="text-red-800 font-bold text-sm">
                            {{ $product->currency ? $product->currency->currency : '' }}
                            {{ $product->currency ? $product->currency->symbol : '$' }}{{ number_format($product->commercial_price, 0, '.', ',') }}
                        </del>
                        <p class="font-bold text-gray-700">
                            {{ $product->currency ? $product->currency->currency : '' }}
                            {{ $product->currency ? $product->currency->symbol : '$' }}{{ number_format($product->price, 0, '.', ',') }}
                        </p>
                        <p
                            class="font-bold text-gray-700 {{ Auth::check() ? (Auth::user()->email == 'yoliesglez@gmail.com' ? 'hidden' : '') : '' }}">
                            Stock: {{ $product->quantity }}
                        </p>
                        {{-- <p class="font-bold text-gray-700">
                            <i class="fas fa-map-marker-alt"></i> {{$product->state->name}}
                        </p> --}}
                    </div>

                    <div class="flex ">
                        <span class="font-bold text-gray-700"><i class="fas fa-map-marker-alt"></i>
                            {{ $product->state->name }}</span>
                    </div>
                </div>

                <div
                    class="mt-4 md:mt-auto mb-4 {{ Auth::check() ? (Auth::user()->email == 'yoliesglez@gmail.com' ? 'hidden' : '') : '' }}">
                    <x-danger-enlace href="{{ route('products.show', $product) }}">
                        Ver producto
                    </x-danger-enlace>
                </div>
            </div>
        </article>
    </li>
    @auth
        @if (Auth::user()->email == 'yoliesglez@gmail.com')
            <span class="text-sm ml-4">{{ explode(' ', $product->updated_at)[0] }}</span>
        @endif
    @endauth
</div>
