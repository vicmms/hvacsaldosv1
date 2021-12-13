<x-app-layout>
    <div class="container">
        <div class="overflow-hidden shadow-lg mt-8 bg-white">
            <div class="px-6 py-4 mb-4">
                <span class="text-2xl"><i class="fas fa-map-marker-alt"></i> Ubicación del vendedor:
                    {{ $seller->state ? $seller->state->name . ', ' . $seller->country->name : $seller->country->name }}
                </span>
            </div>
            <span class="px-6 text-xl font-semibold">Calificaciones recibidas</span>
            @foreach ($califications as $calification)
                <div class="mx-2 px-6 py-4 mb-4 mt-4 rounded bg-gray-100">
                    <div class="font-bold text-xl mb-2 flex">
                        <span class="flex-1">{{ explode(' ',$calification->name)[0] }}</span>
                        <div class="flex">
                            @for ($i = 0; $i < 5; $i++)
                                @if ($i < $calification->score)
                                    <i class="fas fa-star text-xs text-yellow-500 mr-1"></i>
                                @else
                                    <i class="far fa-star text-xs text-yellow-500 mr-1"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-700 text-base">
                        @if ($calification->comments)
                            {{ $calification->comments }}
                        @else
                            No se realizaron comentarios
                        @endif
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
