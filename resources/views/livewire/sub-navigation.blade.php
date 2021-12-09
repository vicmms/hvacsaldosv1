<header class="bg-blue-1 top-16" style="z-index: 900" x-data="dropdown()">

    <div class="container text-white font-semibold flex justify-between">
        <div class="px-6 py-1 flex">
            <a href="/home/{{ session('country') }}" class="hover:text-orange-500">Inicio</a>

            <a :class="{'bg-opacity-100 text-orange-500' : open}" x-on:click="show()"
                class="px-6 md:px-4 hover:text-orange-500 text-white cursor-pointer">
                <span class="hidden md:block">Categorías <i class="fas fa-chevron-down text-xs"></i></span>
            </a>

            <a href="{{ route('categories.show', 'all') }}" class="hover:text-orange-500">
                Todos los productos
            </a>
        </div>
        <div class="px-6 py-1 flex" style="position: relative; left: 25px;">
            <x-jet-dropdown align="right" width="16" class="hidden md:block">
                <x-slot name="trigger">
                    <span class="cursor-pointer hover:text-orange-500">{{session('country')}} <i class="fas fa-chevron-down text-xs"></i></span>
                    {{-- <img class="w-6 h-6 rounded-full object-cover object-center cursor-pointer"
                        src="{{ asset('images/admin/flags/' . session('country') . '.jpg') }}" alt="Mexico"> --}}
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
            <a href="https://www.saldohvac.com/faq-s" target="_blank" alt="Preguntas"
                class="ml-6 hover:text-orange-500 ">
                <i class="fas fa-question-circle text-md text-gray-100"></i> Preguntas frecuentes
                {{-- <span class="tooltiptext">Preguntas frecuentes</span> --}}
            </a>
            @livewire('user-menu')
        </div>
    </div>

    <nav id="navigation-menu" :class="{'block': open, 'hidden': !open}"
        class="bg-trueGray-700 bg-opacity-20 w-full absolute hidden z-50">

        {{-- Menu computadora --}}
        <div class="container  hidden md:block">
            <div x-on:click.away="close()" class="grid grid-cols-4 h-full relative ml-20">
                <ul class="bg-white rounded-b-xl rounded-tr-xl">
                    @foreach ($categories as $category)
                        <li class="navigation-link text-trueGray-500 hover:bg-orange-500 hover:text-white">
                            <a href="{{ route('categories.show', $category) }}"
                                class="py-2 px-4 text-sm flex items-center">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
</header>
