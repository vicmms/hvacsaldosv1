<div>
    <div class="ml-4 underline">
        <button wire:click="changeModal" wire:loading.attr="disabled" wire:target="changeModal"
            class="bg-gray-100 font-semibold {{$rating ? 'text-green-500' : 'text-orange-500'}} rounded-xl px-2 py-1">
            @if ($rating)
                <i class="fas fa-check text-sm"></i> Compra calificada
            @else
                <i class="fas fa-star text-sm"></i> Calificar compra
            @endif
        </button>
    </div>
    <x-jet-dialog-modal wire:model="isOpen">

        <x-slot name="title">
            <span class="font-semibold text-xl">Califica tu compra</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-3">
                <div>
                    <x-jet-label class="text-lg font-semibold">
                        Califica al vendedor
                    </x-jet-label>

                    <div class="rating rating2 text-xl">
                        @if (!$stars)
                        <a class="star" href="#5" wire:click="setStars(5)" title="Give 5 stars">★</a>
                        <a class="star" href="#4" wire:click="setStars(4)" title="Give 4 stars">★</a>
                        <a class="star" href="#3" wire:click="setStars(3)" title="Give 3 stars">★</a>
                        <a class="star" href="#2" wire:click="setStars(2)" title="Give 2 stars">★</a>
                        <a class="star" href="#1" wire:click="setStars(1)" title="Give 1 star">★</a>
                        @else
                            <div class="flex">
                                <button class="text-sm" wire:click="resetStars">Cambiar calificación <i class="fas fa-pen"></i> </button>

                                <div class="flex-1">
                                    @for ($i = 5; $i != 0; $i--)
                                        @if ($i <= $stars)
                                        <a class="pointer-events-none active-star" title="Give {{$i}} stars">★</a>
                                        @else
                                        <a class="pointer-events-none"  title="Give {{$i}} stars">★</a>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        @endif
                        
                    </div>

                </div>
                <x-jet-label class="text-lg font-semibold">
                    Opina sobre tu producto "{{ json_decode($order->content)->name }}"
                </x-jet-label>
                <textarea wire:model="comments" rows="5" class="form-control w-full"></textarea>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-danger-button wire:click="save">
                Calificar Producto
            </x-jet-danger-button>
        </x-slot>

    </x-jet-dialog-modal>
</div>
