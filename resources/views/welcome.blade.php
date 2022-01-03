<x-app-layout>
    <style>
        .animate-bounce {
            height: 200px;
            position: absolute;
            left: 50%;
            top: 40%;
            filter: drop-shadow(0px 2px 1px black);
        }

        .flex-caption {
            width: 100%;
            padding: 2%;
            left: 0;
            bottom: 0;
            background: rgba(0, 0, 0, .5);
            color: #fff;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, .3);
            font-size: 14px;
            line-height: 18px;
        }

        .flex-direction-nav {
            display: none !important;
        }

        .hot-pattern {
            background-image: url("/images/pattern.png");
            /*background-repeat: repeat;
            background-size: 100px; */
        }

        .esquina {
            background: linear-gradient(45deg, rgb(15, 6, 65) 80%, transparent 20%) !important;
        }

    </style>
    @if (Auth::check())
        @if (!Auth::user()->email_verified_at)
            <div class="w-full bg-yellow-400 text-center text-white font-semibold">
                <a href="/email/verify"><i class="fas fa-exclamation-circle"></i> Verifica tu correo para evitar
                    restricciones en tu cuenta</a>
            </div>
        @endif
    @endif
    @if (Auth::check())
        @if (Auth::user()->email == 'melisha.ra7@gmail.com' || Auth::user()->email == 'melishara7@gmail.com')
            <div class="parpadea w-full bg-red-400 text-center text-white font-semibold">
                <a href="https://www.youtube.com/watch?v=6vX6C5wnJdI" target="_blank">¡Felicidades, eres el usuario
                    #1,000,000 en visitar este sitio, da click sobre este banner y llevate una sorpresa!<i
                        class="fas fa-heart"></i></a>
            </div>
        @endif
    @endif
    <div class="flex items-center justify-center space-x-2 animate-bounce mt-8" style="height: 200px">
        <div class="w-4 h-4 bg-blue-700 rounded-full"></div>
        <div class="w-4 h-4 bg-purple-700 rounded-full"></div>
        <div class="w-4 h-4 bg-orange-500 rounded-full"></div>
    </div>
    <div class="container py-8 blur" id="main-content">

        {{-- oferta web --}}
        <div class="flexslider hidden lg:block" style="height: 420px !important;">
            <ul class="slides" style="height: 350px !important;">
                <li>
                    <a href="{{ route('offers') }}">
                        <img style="width: 1200px; height: 410px;" class=""
                            src="{{ asset('images/banner.jpg') }}" />
                    </a>
                </li>
                @foreach ($ofertas as $oferta)
                    <li class="flex">
                        <a href="{{ route('products.show', $oferta) }}">
                            <img src="{{ asset('images/pattern-red.png') }}" style="width: 1200px; height: 410px;"
                                class="absolute z-40">
                            <div class="text-white absolute font-bold pt-20">
                                <div class="relative text-2xl pr-10 py-2 z-50"
                                    style="width: fit-content; padding-left: 2rem; background-color: rgb(20, 10, 82);">
                                    <span class="">
                                        @foreach (explode(' ', $oferta->name) as $key => $word)
                                            {{ $word . ' ' }}
                                            @if ($key == 5)
                                                <br>
                                            @endif
                                        @endforeach
                                    </span>
                                </div>
                                <div class="mt-4 relative text-2xl pr-8 py-2 z-50"
                                    style="width: fit-content; padding-left: 2rem; background-color: rgb(240, 240, 240); color: rgb(20, 10, 82);">
                                    <span class="">Precio comercial
                                        {{ $oferta->currency ? $oferta->currency->currency : '' }}
                                        <del>
                                            {{ $oferta->currency ? $oferta->currency->symbol : '$' }}{{ number_format($oferta->commercial_price, 0, '.', ',') }}
                                        </del>
                                    </span>
                                </div>
                                <div class=" relative text-4xl pr-44 py-2 esquina z-50"
                                    style="padding-left: 2rem; background-color: rgb(20, 10, 82); width: fit-content">
                                    <span class="">A tan solo
                                        {{ $oferta->currency ? $oferta->currency->currency : '' }}
                                        {{ $oferta->currency ? $oferta->currency->symbol : '$' }}{{ number_format($oferta->price, 0, '.', ',') }}
                                    </span>
                                </div>
                                {{-- <p>Precio comercial: <del>{{ $oferta->commercial_price }}</del> </p> --}}
                            </div>
                            <div class="z-10 relative ml-auto bg-center bg-no-repeat bg-cover blur-md"
                                style="width: 510px; height: 405px; background-image: url({{ asset($oferta->images->first()->url) }}); filter: blur(12px);">
                            </div>
                            <div class="z-10 relative ml-auto" style="width: 515px; height: 412px; top: -405px">
                                <img style="height: 410px !important; width: auto !important;"
                                    class="rounded object-contain mx-auto"
                                    src="{{ asset($oferta->images->first()->url) }}" />
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- oferta movil --}}
        <div>
            <img class="h-full mb-6"
                            src="{{ asset('images/banner.jpg') }}" />
        </div>

        @foreach ($categories as $category)

            <section class="mb-6">
                <div class="flex items-center mb-2">
                    <h1 class="text-lg uppercase font-semibold text-gray-700">
                        {{ $category->name }}
                    </h1>

                    <a href="{{ route('categories.show', ['category' => $category, 'country' => $country]) }}"
                        class="text-orange-500 hover:text-orange-400 hover:underline ml-2 font-semibold">Ver más</a>

                </div>
                @livewire('category-products', ['category' => $category, 'country' => $country])
            </section>

        @endforeach
    </div>


    @push('script')

        <script>
            Livewire.on('glider', function(id) {

                new Glider(document.querySelector('.glider-' + id), {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    draggable: true,
                    dots: '.glider-' + id + '~ .dots',
                    arrows: {
                        prev: '.glider-' + id + '~ .glider-prev',
                        next: '.glider-' + id + '~ .glider-next'
                    },
                    responsive: [{
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 2.5,
                                slidesToScroll: 2,
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 3.5,
                                slidesToScroll: 3,
                            }
                        },

                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 4.5,
                                slidesToScroll: 4,
                            }
                        },

                        {
                            breakpoint: 1280,
                            settings: {
                                slidesToShow: 5.5,
                                slidesToScroll: 5,
                            }
                        },
                    ]
                });

            });
            $(document).ready(function() {
                $('.flexslider').flexslider({
                    animation: "slide"
                });
            });
        </script>

    @endpush

</x-app-layout>
