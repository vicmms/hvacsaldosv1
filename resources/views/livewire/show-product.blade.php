<div>
    <style>
        .cover-image {
            height: 550px !important;
            object-fit: contain;
        }

    </style>
    <div class="container py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
            <div wire:ignore>
                <div class="flexslider">
                    <ul class="slides">
                        @if (!count($product->images))
                            <li data-thumb=" {{ asset('images/image-not-found.png') }}">
                                <img src=" {{ asset('images/image-not-found.png') }}" />
                            </li>
                        @endif
                        @foreach ($product->images as $image)

                            <li data-thumb=" {{ asset($image->url) }}">
                                <img class="cover-image" src=" {{ asset($image->url) }}" />
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
                <p class="text-trueGray-700 font-semibold">Categoría: {{ $product->category->name }}</p>

                <p class="text-trueGray-700 font-semibold capitalize">Subcategoría: {{ $product->subcategory->name }}</p>

                <p class="text-trueGray-700 font-semibold capitalize">Marca: {{ $product->brand->name }}</p>
                <p class="text-trueGray-700 font-semibold capitalize">Modelo: {{ $product->model }}</p>
                <p class="text-trueGray-700 font-semibold capitalize">No. Serie: {{ $product->serie_number ? $product->serie_number : 'No especificado' }}</p>

                <p class="text-2xl font-semibold capitalize text-trueGray-700 my-4">Precio de Venta:
                    {{ $product->currency ? $product->currency->currency : '' }}
                    {{ $product->currency ? $product->currency->symbol : '$' }}{{ number_format($product->price, 0, '.', ',') }}
                </p>
                <p class="text-xl font-semibold capitalize my-4">Precio Comercial:
                    <del class="text-red-800">
                        {{ $product->currency ? $product->currency->currency : '' }}
                        {{ $product->currency ? $product->currency->symbol : '$'}}{{ number_format($product->commercial_price, 0, '.', ',') }}
                    </del>
                </p>

                <p class="text-xl font-semibold capitalize my-4">Ubicación:
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
                                {{-- <p>{{ $product->shipping_cost ? 'Costo de envío: ' . $product->shipping_cost : 'Sin costo extra' }}
                                </p> --}}

                            @endif
                        </div>
                    </div>
                </div>

                @livewire('add-cart-item', ['product' => $product])

                <div class="mt-6 text-gray-700">
                    <h2 class="font-bold text-lg">Descripción</h2>
                    <p class="bg-white p-4 rounded-lg shadow-lg">{!! $product->description !!}</p>
                </div>
            </div>
        </div>

        @livewire('create-question',['product' => $product])

        <div class="mt-6 text-gray-700 bg-white p-4 rounded-lg mb-4 shadow-lg">
            <h2 class="font-bold text-2xl mb-8">Preguntas Realizadas</h2>
            @foreach ($questions as $question)
                <div class="mb-4">
                    <div class="flex">
                        <p class="flex-1">{{ $question->question }}</p>
                        <p class="w-28 text-xs text-gray-400">{{ explode(' ', $question->created_at)[0] }}</p>
                    </div>
                    @if ($question->answer)
                        <div class="ml-4 flex">
                            <svg class="ui-pdp-icon ui-pdp-qadb__questions-list__question__answer-container__icon"
                                xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
                                <path fill="#000" fill-opacity=".25" fill-rule="evenodd" d="M0 0h1v11h11v1H0z"></path>
                            </svg>
                            <p class="ml-1 flex-1  text-gray-500">{{ $question->answer->answer }}</p>
                            <p class="w-28 text-xs text-gray-400">
                                {{ explode(' ', $question->answer->created_at)[0] }}</p>
                        </div>
                    @elseif(Auth::check())
                        @if ($product->user_id == Auth::user()->id)
                            <form
                                wire:submit.prevent="saveAnswer(Object.fromEntries(new FormData($event.target)),{{ $question->id }})"
                                class="flex">
                                <x-jet-input name="answer" class="flex-1 bg-gray-100 p-2" required />
                                <x-jet-secondary-button class="
                            ml-2"
                                    placeholder="Ingrese una respuesta" type="submit">
                                    Responder
                                </x-jet-secondary-button>
                            </form>
                            <x-jet-input-error for="formData.answer" />
                        @endif
                    @endif
                </div>
            @endforeach
            @if ($questions->hasPages())

                <div class="px-6 py-4">
                    {{ $questions->links() }}
                </div>

            @endif
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
</div>
