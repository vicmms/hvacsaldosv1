<div class="bg-white shadow-xl rounded-lg p-6 mb-4">
    <p class="text-2xl text-center font-semibold mb-2">Estado del producto</p>

    <div class="grid grid-cols-3 text-center my-4">
        <label class="{{ $status == 1 ? 'bg-yellow-300 font-semibold ' : 'bg-yellow-100' }} px-2 py-4 rounded-l-3xl">
            <input wire:model="status" type="radio" name="status" value="1" class="mr-2">
            En revisión
        </label>
        <label class="{{ $status == 2 ? 'bg-green-300 font-semibold ' : 'bg-green-100' }} px-2 py-4">
            <input wire:model="status" type="radio" name="status" value="2" class="mr-2">
            Publicado
        </label>
        <label class="{{ $status == 3 ? 'bg-red-400 font-semibold text-white' : 'bg-red-100' }}  px-2 py-4 rounded-r-3xl">
            <input wire:model="status" type="radio" name="status" value="3" class="mr-2">
            Rechazado
        </label>
    </div>

    <div class="flex justify-end items-center">

        <x-jet-action-message class="mr-3" on="saved">
            Actualizado
        </x-jet-action-message>
        
        @if ($status != 3)
            <x-jet-button wire:click="save"
                wire:loading.attr="disabled"
                wire:target="save">
                Actualizar
            </x-jet-button>
        @else
            <x-jet-button wire:click="changeModal"
                wire:loading.attr="disabled"
                wire:target="changeModal">
                Actualizar
            </x-jet-button>
        @endif
    </div>

    <x-jet-dialog-modal wire:model="isOpen">

        <x-slot name="title">
            Solicitar revisión del producto
        </x-slot>

        <x-slot name="content">

            <div class="space-y-3">

                <div>
                    <x-jet-label>
                        Describe claramente los motivos por los cuales el producto no puede ser publicado
                    </x-jet-label>

                    <textarea name="message" rows="5" wire:model="message" class="w-full mt-1 form-control"></textarea>

                    <x-jet-input-error for="message" />
                </div>

            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-danger-button wire:click="rechazar" wire:loading.attr="disabled" wire:target="rechazar">
                Rechazar producto
            </x-jet-danger-button>
        </x-slot>

    </x-jet-dialog-modal>

</div>