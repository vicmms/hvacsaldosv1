<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if ($request->registered)
                <div class="flex items-start bg-orange-400 text-white text-sm font-bold px-4 py-3 mb-4" fill="white" role="alert">
                    <i class="fas fa-info-circle text-lg mr-2"></i>
                    <p> Antes de continuar por favor ayudanos a completar la información de tu perfil, o si lo prefieres puedes pasar directamente a <a href="{{route('home')}}" class="underline">ver los productos</a>.</p> 
                </div>
            @endif
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-jet-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.update-company-form')
            </div>

            <x-jet-section-border />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-jet-section-border />
            @endif

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-jet-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
