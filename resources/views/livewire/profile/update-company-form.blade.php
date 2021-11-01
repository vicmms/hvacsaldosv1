<x-jet-form-section submit="save">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!--Company Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Nombre de la empresa') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="name" autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <!-- datos facturacion -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="datos_facturacion" value="{{ __('Datos de facturación') }}" />
            <textarea id="datos_facturacion" type="text" class="form-control mt-1 block w-full" wire:model.defer="data"
                rows="3"></textarea>
            <x-jet-input-error for="data" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="save">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
