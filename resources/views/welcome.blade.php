<x-app-layout>
    <style>
        .animate-bounce {
            height: 200px;
            position: absolute;
            left: 50%;
            top: 40%;
            filter: drop-shadow(0px 2px 1px black);
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
                <a href="https://www.youtube.com/watch?v=6vX6C5wnJdI" target="_blank">¡Felicidades, eres el usuario #1,000,000 en visitar este sitio, da click sobre este banner y llevate una sorpresa!<i class="fas fa-heart"></i></a>
            </div>
        @endif
    @endif
    <div class="flex items-center justify-center space-x-2 animate-bounce mt-8" style="height: 200px">
        <div class="w-4 h-4 bg-blue-700 rounded-full"></div>
        <div class="w-4 h-4 bg-purple-700 rounded-full"></div>
        <div class="w-4 h-4 bg-orange-500 rounded-full"></div>
    </div>
    <div class="container py-8 blur" id="main-content">
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
        </script>

    @endpush

</x-app-layout>
