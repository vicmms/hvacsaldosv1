<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Gracias por registrarte! Antes de empezar por favor verifica tu correo electrónico, te hemos enviado un correo con los pasos a seguir, o bien puedes solicitar que te reenviemos ese correo dando clic en el siguiente botón. Recuerda revisar en correos no deseados o spam.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Se ha enviado un nuevo link de verificvación al correo proporcionado') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-jet-button type="submit">
                        {{ __('Reenviar verificación') }}
                    </x-jet-button>
                </div>
            </form>
            <div>
                <a href="/">
                    <button class="underline text-sm text-gray-600 hover:text-gray-900">
                        {{ __('Regresar') }}
                    </button>
                </a>
            </div>

            {{-- <form method="POST" action="{{ route('logout') }}">
                @csrf
                
                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Cerrar sesión') }}
                </button>
            </form> --}}
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
