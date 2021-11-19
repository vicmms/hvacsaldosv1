<div wire:init="loadPosts">
    @if (count($products))
        <div class="glider-contain">
            <ul class="glider-{{ $category->id }}">

                @foreach ($products as $product)

                    <li class="bg-white rounded-lg shadow {{ $loop->last ? '' : 'sm:mr-4' }} border-2">
                        <a href="{{ route('products.show', $product) }}">
                            <article>
                                <figure class="border-b-4 border-orange-500">
                                    <img class="h-48 w-full object-cover object-center"
                                        src="{{ count($product->images) ? asset($product->images->first()->url) : asset('/images/image-not-found.png') }}"
                                        alt="">
                                </figure>

                                <div class="py-4 px-6">
                                    <h1 class="text-lg font-semibold">
                                        {{ Str::limit($product->name, 15) }}
                                    </h1>
                                    <p class="font-bold text-trueGray-700">
                                        {{ $product->currency ? $product->currency->currency : '' }}
                                        {{ $product->currency ? $product->currency->symbol : '$'}}{{ number_format($product->price, 0, '.', ',') }}
                                    </p>
                                </div>
                            </article>
                        </a>
                    </li>
                @endforeach

            </ul>

            <button aria-label="Previous" class="glider-prev">«</button>
            <button aria-label="Next" class="glider-next">»</button>
            <div role="tablist" class="dots"></div>
        </div>

    @else

        <div class="flex items-center justify-center space-x-2 animate-bounce mt-8" style="height: 200px">
            <div class="w-4 h-4 bg-blue-700 rounded-full"></div>
            <div class="w-4 h-4 bg-purple-700 rounded-full"></div>
            <div class="w-4 h-4 bg-orange-500 rounded-full"></div>
        </div>

    @endif
</div>
