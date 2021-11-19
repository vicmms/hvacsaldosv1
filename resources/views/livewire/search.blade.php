<div class="flex-1 relative" x-data>
    <style>
        .search-pin{
            position: absolute;
            top: -1.8rem;
            left: 1rem;
            font-size: 3rem;
            z-index: -1;
        }
        .bg-modal{
            width: 120vw;
            height: 100vh;
            background-color: #3f4242;
            left: -75%;
            top: -0.8rem;
            opacity: 0.4;
            z-index: -1;
        }
    </style>

    <form action="{{ route('search') }}" autocomplete="off">

        <x-jet-input name="name" wire:model="search" type="text" class="w-full rounded-xl"
            placeholder="¿Estás buscando algún producto?" />

        <button class="absolute top-0 right-0 w-12 h-full bg-orange-500 flex items-center justify-center rounded-r-xl">
            <i class="fas fa-search text-xl text-white" style="-webkit-text-stroke: 1px rgba(249, 115, 22, var(--tw-bg-opacity));"></i>
        </button>

    </form>

    <div class="absolute w-full mt-6 hidden" :class="{ 'hidden' : !$wire.open }" @click.away="$wire.open = false">
        <div class="absolute bg-modal" wire:click="resetSearch()"></div>
        <div class="bg-orange-100 rounded-lg shadow-lg">
            <i class="fas fa-caret-up search-pin text-orange-100"></i>
            <div class="px-4 py-3 space-y-1">
                @forelse ($products as $product)
                    <a href="{{ route('products.show', $product) }}" class="flex hover:bg-orange-200">
                        <img class="w-16 h-12 object-cover"
                            src="{{ count($product->images) ? asset($product->images->first()->url) : asset('images/image-not-found.png') }}"
                            alt="">
                        <div class="ml-4 text-gray-700">
                            <p class="text-lg font-semibold leading-5 ">{{ $product->name }}</p>
                            <p class="">Categoria: {{ $product->category->name }}</p>
                        </div>
                    </a>
                @empty
                    <p class="text-lg leading-5">
                        No existe ningún registro con los parametros especificados
                    </p>
                @endforelse
            </div>
        </div>
    </div>
</div>
