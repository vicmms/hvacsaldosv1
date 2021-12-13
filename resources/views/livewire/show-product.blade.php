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
                <p class="text-trueGray-700 font-semibold">Categoría: {{ $product->category->name }}</p>

                <p class="text-trueGray-700 font-semibold capitalize">Subcategoría: <span class="text-green-600">{{ $product->subcategory->name }}</span>
                </p>

                <p class="text-trueGray-700 font-semibold capitalize">Marca: {{ $product->brand->name }}</p>
                <p class="text-trueGray-700 font-semibold capitalize">Modelo: {{ $product->model }}</p>
                <p class="text-trueGray-700 font-semibold capitalize">No. Serie:
                    {{ $product->serie_number ? $product->serie_number : 'No especificado' }}</p>

                <p class="text-2xl font-semibold capitalize text-trueGray-700 my-4">Precio de Venta:
                    {{ $product->currency ? $product->currency->currency : '' }}
                    {{ $product->currency ? $product->currency->symbol : '$' }}{{ number_format($product->price, 0, '.', ',') }}
                </p>
                <p class="text-xl font-semibold capitalize my-4">Precio Comercial:
                    <del class="text-red-800">
                        {{ $product->currency ? $product->currency->currency : '' }}
                        {{ $product->currency ? $product->currency->symbol : '$' }}{{ number_format($product->commercial_price, 0, '.', ',') }}
                    </del>
                </p>

                {{-- vendedor --}}
                <div class="flex items-center text-xl font-semibold capitalize my-4">
                        <p class="mr-4">Vendedor:</p>
                        @if ($seller->score > 0)
                            @for ($i = 0; $i < 5; $i++)
                                @if (round($seller->score) >= $seller->score)
                                    @if ($i < $seller->score)
                                        <i class="fas fa-star text-xs text-yellow-500 mr-1"></i>
                                    @else
                                        <i class="far fa-star text-xs text-yellow-500 mr-1"></i>
                                    @endif
                                @else
                                    @if ($i < ($seller->score - 1))
                                        <i class="fas fa-star text-xs text-yellow-500 mr-1"></i>
                                    @else
                                        @if ($i < $seller->score)
                                            <i class="fas fa-star-half-alt text-xs text-yellow-500 mr-1"></i>
                                        @else
                                            <i class="far fa-star text-xs text-yellow-500 mr-1"></i>
                                        @endif
                                    @endif
                                @endif
                            @endfor
                            <p class="text-sm">({{$seller->score}})</p>
                            <a class="text-lg ml-auto underline" href="{{route('seller-review', encrypt($product->user_id))}}">Ver calificaciones</a>
                        @else
                            <p class="text-trueGray-700">Aún no se ha calificado este vendedor</p>
                        @endif
                </div>

                <p class="text-xl font-semibold capitalize my-4">Ubicación:
                    {{ $product->state->name }}
                </p>

                <div class="bg-white rounded-lg shadow-lg mb-6">
                    <p class="text-xl font-semibold text-gray-900 p-2">Envios Disponibles</p>
                    @foreach (explode(',', str_replace(['[', ']', '"'], '', $product->shipping)) as $shipping)
                    @switch($shipping)
                            @case(1)
                            <div class="p-2 flex items-center">
                                <span class="flex items-center justify-center h-7 w-7 rounded-full bg-greenLime-600">
                                    <i class="fas fa-check text-sm text-white"></i>
                                </span>

                                <div class="ml-4">
                                    <p class="text-lg font-semibold text-blue-900">
                                        Con costo extra
                                    </p>
                                </div>
                            </div>
                                @break
                            @case(2)
                            <div class="p-2 flex items-center">
                                <span class="flex items-center justify-center h-7 w-7 rounded-full bg-greenLime-600">
                                    <i class="fas fa-check text-sm text-white"></i>
                                </span>

                                <div class="ml-4">
                                    <p class="text-lg font-semibold text-blue-900">
                                        Recolección en oficinas del vendedor
                                    </p>
                                </div>
                            </div>
                                @break
                                @case(3)
                            <div class="p-2 flex items-center">
                                <span class="flex items-center justify-center h-7 w-7 rounded-full bg-greenLime-600">
                                    <i class="fas fa-check text-sm text-white"></i>
                                </span>

                                <div class="ml-4">
                                    <p class="text-lg font-semibold text-blue-900">
                                        Gratis dentro de la ciudad
                                    </p>
                                </div>
                            </div>
                                @break
                            @default
                                        
                @endswitch
                    @endforeach
                </div>

                @livewire('add-cart-item', ['product'=> $product])

                        <div class="mt-6 text-gray-700">
                            <h2 class="font-bold text-lg">Descripción</h2>
                            <p class="bg-white p-4 rounded-lg shadow-lg">{!! $product->description !!}</p>
                        </div>
                </div>
            </div>

            @livewire('create-question',['product' => $product])

            <div class="mt-6 text-gray-700 bg-white p-4 rounded-lg mb-4 shadow-lg">
                <h2 class="font-bold text-2xl mb-6">Preguntas Realizadas</h2>
                @forelse ($questions as $question)
                    <div class="mb-4">
                        <div class="flex">
                            <p class="flex-1">{{ $question->question }}</p>
                            <p class="w-28 text-xs text-gray-400">{{ explode(' ', $question->created_at)[0] }}</p>
                        </div>
                        @if ($question->answer)
                            <div class="ml-4 flex">
                                <svg class="ui-pdp-icon ui-pdp-qadb__questions-list__question__answer-container__icon"
                                    xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
                                    <path fill="#000" fill-opacity=".25" fill-rule="evenodd" d="M0 0h1v11h11v1H0z">
                                    </path>
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
                @empty
                    <p class="font-semibold text-lg ml-2">Aún no se han realizado preguntas</p>
                @endforelse
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
