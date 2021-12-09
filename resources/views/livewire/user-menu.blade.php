<div class="mx-6 relative hidden md:block">
    <style>
        .text-xxs{
            font-size: 6px;
        }
    </style>
    @auth

        <x-jet-dropdown align="right" width="48">
            <x-slot name="trigger">
                <div class="flex">
                    <button
                    class="font-semibold transition hover:text-orange-500 focus:outline-none">
                    {{-- <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                        alt="{{ Auth::user()->name }}" /> --}}
                        Mi cuenta
                    </button>
                    {!! $notifications ? '<i class="fas fa-bell text-xs text-red-600 "></i>' : '' !!}
                </div>
            </x-slot>

            <x-slot name="content">
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Cuenta') }}
                </div>

                <x-jet-dropdown-link href="{{ route('profile.show') }}">
                    {{ __('Profile') }}
                </x-jet-dropdown-link>

                <x-jet-dropdown-link href="{{ route('orders.index') }}">
                    Mis ordenes
                </x-jet-dropdown-link>

                <x-jet-dropdown-link href="{{ route('admin.index') }}">
                    Vender / Administrar {!! $notifications ? '<i class="fas fa-circle text-xxs text-red-600 ml-2 align-top pt-1"></i>' : '' !!}
                </x-jet-dropdown-link>

                <div class="border-t border-gray-100"></div>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-dropdown-link href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                                                                                                                                                                                                                                                                                this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-jet-dropdown-link>
                </form>
            </x-slot>
        </x-jet-dropdown>

    @else

        <x-jet-dropdown align="right" width="48">

            <x-slot name="trigger">
                <span class="hover:text-orange-500 font-semibold cursor-pointer">Iniciar sesión</span>
            </x-slot>

            <x-slot name="content">
                <x-jet-dropdown-link href="{{ route('login') }}">
                    {{ __('Login') }}
                </x-jet-dropdown-link>

                <x-jet-dropdown-link href="{{ route('register') }}">
                    {{ __('Register') }}
                </x-jet-dropdown-link>
            </x-slot>

        </x-jet-dropdown>

    @endauth
</div>
