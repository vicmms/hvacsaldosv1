<header class="bg-blue-1 sticky top-0" style="z-index: 900" x-data="dropdown()">
    <div class="container flex items-center h-16 justify-between md:justify-start">
        <a :class="{'bg-opacity-100 text-orange-500' : open}" x-on:click="show()"
            class="flex flex-col items-center justify-center order-last md:order-first px-6 md:px-4 bg-white bg-opacity-25 text-white cursor-pointer font-semibold h-full">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>

            <span class="text-sm hidden md:block">Categorías</span>
        </a>

        <a href="/home/{{ session('country') }}" class="mx-6">
            <x-jet-application-mark class="block h-9 w-auto" />
        </a>

        <div class="mr-6 relative hidden md:block">
            <x-jet-dropdown align="right" width="16">

                <x-slot name="trigger">
                    <img class="w-8 h-8 rounded-full object-cover object-center cursor-pointer"
                        src="{{ asset('images/admin/flags/' . session('country') . '.jpg') }}" alt="Mexico">
                </x-slot>
                <x-slot name="content">
                    @foreach ($tlds as $tld)
                        @if ($tld['tld'] != session('country') && strlen($tld['tld']))
                            <x-jet-dropdown-link href="/home/{{ $tld['tld'] }}">
                                <img class="w-8 h-8 rounded-full object-cover object-center cursor-pointer"
                                    src="{{ asset('images/admin/flags/' . $tld['tld'] . '.jpg') }}" alt="">
                            </x-jet-dropdown-link>
                        @endif
                    @endforeach
                </x-slot>

            </x-jet-dropdown>
        </div>

        <div class="flex-1 hidden md:block">
            @livewire('search')
        </div>

        <div class="hidden md:block">
            <a href="https://www.saldohvac.com/faq-s" target="_blank" alt="Preguntas" class="ml-6 mt-1 tooltip ">
                <i class="fas fa-question-circle h-9 text-3xl text-gray-100"></i>
                <span class="tooltiptext">Preguntas frecuentes</span>
            </a>
        </div>

        @livewire('user-menu')

        <div class="hidden md:block">
            @livewire('dropdown-cart')
        </div>

    </div>

    <nav id="navigation-menu" :class="{'block': open, 'hidden': !open}"
        class="bg-trueGray-700 bg-opacity-20 w-full absolute hidden">

        {{-- Menu computadora --}}
        <div class="container  hidden md:block">
            <div x-on:click.away="close()" class="grid grid-cols-4 h-full relative">
                <ul class="bg-white rounded-b-xl rounded-tr-xl">
                    {{-- <li class="navigation-link text-trueGray-500 hover:bg-orange-500 hover:text-white">
                        <a href="{{ route('categories.show', null) }}"
                            class="py-2 px-4 text-sm flex items-center">
                            Todos los productos
                        </a>
                        <div class="navigation-submenu bg-gray-100 absolute w-3/4 h-full top-0 right-0 hidden">
                            <x-navigation-subcategories :category="$category" :subcategories="$subcategories" />
                        </div>
                    </li> --}}
                    @foreach ($categories as $category)
                        <li class="navigation-link text-trueGray-500 hover:bg-orange-500 hover:text-white">
                            <a href="{{ route('categories.show', $category) }}"
                                class="py-2 px-4 text-sm flex items-center">
                                {{ $category->name }}
                            </a>
                            {{-- <div class="navigation-submenu bg-gray-100 absolute w-3/4 h-full top-0 right-0 hidden">
                                <x-navigation-subcategories :category="$category" :subcategories="$subcategories" />
                            </div> --}}
                        </li>
                    @endforeach
                </ul>

                {{-- <div class="col-span-3 bg-gray-100">
                    <x-navigation-subcategories :category="$categories->first()" :subcategories="$subcategories" />
                </div> --}}
            </div>
        </div>

        {{-- menu mobil --}}
        <div class="bg-white h-full overflow-y-auto md:hidden">

            <div class="container bg-gray-200 py-3 mb-2">
                @livewire('search')
            </div>

            <ul>
                @foreach ($categories as $category)
                    <li class="text-trueGray-500 hover:bg-orange-500 hover:text-white">
                        <a href="{{ route('categories.show', $category) }}"
                            class="py-2 px-4 text-sm flex items-center">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <p class="text-trueGray-500 px-6 my-2">USUARIOS</p>

            @livewire('cart-mobil')

            @auth
                <a href="{{ route('profile.show') }}"
                    class="py-2 px-4 text-sm flex items-center text-trueGray-500 hover:bg-orange-500 hover:text-white">

                    <span class="flex justify-center w-9">
                        <i class="far fa-address-card"></i>
                    </span>

                    Perfil
                </a>

                <a href=""
                    onclick="event.preventDefault();
                                                                                                                                                                                                                                                                                                        document.getElementById('logout-form').submit() "
                    class="py-2 px-4 text-sm flex items-center text-trueGray-500 hover:bg-orange-500 hover:text-white">

                    <span class="flex justify-center w-9">
                        <i class="fas fa-sign-out-alt"></i>
                    </span>

                    Cerrar sesión
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>

            @else
                <a href="{{ route('login') }}"
                    class="py-2 px-4 text-sm flex items-center text-trueGray-500 hover:bg-orange-500 hover:text-white">

                    <span class="flex justify-center w-9">
                        <i class="fas fa-user-circle"></i>
                    </span>

                    Iniciar sesión
                </a>

                <a href="{{ route('register') }}"
                    class="py-2 px-4 text-sm flex items-center text-trueGray-500 hover:bg-orange-500 hover:text-white">

                    <span class="flex justify-center w-9">
                        <i class="fas fa-fingerprint"></i>
                    </span>

                    registrate
                </a>
            @endauth
        </div>
    </nav>
    @push('script')
        <script>
            var pusher = new Pusher('3d9b40bd878ed43b82cf', {
                cluster: 'us2'
            });

            var channel = pusher.subscribe('nav-channel');
            channel.bind('nav-event', function() {
                console.log('pusher')
                livewire.emit('updateMainNotifications');
            });
        </script>
    @endpush
</header>
