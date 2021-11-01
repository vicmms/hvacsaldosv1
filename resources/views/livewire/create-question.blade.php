<div class="mt-6 text-gray-700">
    @if (Auth::check())
        <h2 class="font-bold text-lg">Realizar una pregunta</h2>
        <div class="bg-white p-4 rounded-lg shadow-lg mb-4 flex">
            <x-jet-input class="flex-1 bg-gray-100 p-2" placeholder="Ingresa la pregunta" wire:model="question" />
            <x-jet-danger-button class="mx-2" wire:click="addQuestion">
                Enviar
            </x-jet-danger-button>
        </div>
    @else
        <h2 class="font-bold text-lg">Inicia sesión para realizar una pregunta</h2>
    @endif
</div>
