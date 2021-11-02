<div class="mt-6 text-gray-700">
    @if (Auth::check())
        <h2 class="font-bold text-lg mb-2">Realizar una pregunta</h2>
        <form class="bg-white p-4 rounded-lg shadow-lg mb-4 flex" wire:submit.prevent="addQuestion">
            <x-jet-input required class="flex-1 bg-gray-100 p-2" placeholder="Ingresa la pregunta"
                wire:model="question" />
            <x-jet-danger-button class="mx-2" type="submit">
                Enviar
            </x-jet-danger-button>
        </form>
    @else
        <h2 class="font-bold text-lg">Inicia sesión para realizar una pregunta</h2>
    @endif
</div>
