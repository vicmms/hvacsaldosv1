<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="country_id" value="{{ __('País') }}" />
                <select name="country_id" id="country_id" class="form-control block mt-1 w-full">
                    <option value="" selected disabled>Selecciona tu país</option>
                    @foreach ($countries as $pais)
                        <option value="{{ $pais->id }}">{{ $pais->name }}</option>
                    @endforeach
                </select>
                {{-- <x-jet-input id="country_id" class="block mt-1 w-full" type="text" name="country_id" required /> --}}
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms" />

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
    'terms_of_service' => '<a target="_blank" href="' . route('terms.show') . '" class="underline text-sm text-gray-600 hover:text-gray-900">' . __('Terms of Service') . '</a>',
    'privacy_policy' => '<a target="_blank" href="' . route('policy.show') . '" class="underline text-sm text-gray-600 hover:text-gray-900">' . __('Privacy Policy') . '</a>',
]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end my-6">
                <input type="checkbox" name="politicas" id="politicas" class="form-control mr-2" onclick="Enable(this, 'btnRegister')">
                <span class="text-sm">
                    He leido y acepto las
                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                        href="https://www.saldohvac.com/privacidad">
                        {{ __('politicas de privacidad y seguridad ') }}
                    </a>

                </span>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Ya tengo una cuenta') }}
                </a>

                <x-jet-button class="ml-4" id="btnRegister" disabled>
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
    <script>
        Enable = function(checkbox, btnId) {
            document.getElementById(btnId).disabled = !checkbox.checked; 
        }
    </script>
</x-guest-layout>
