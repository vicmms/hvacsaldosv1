<x-app-layout>

    <div class="container py-8">
        {{-- <figure class="mb-4">
            <img class="w-full h-80 object-cover object-center" src="{{ asset($category->image) }}" alt="">
        </figure> --}}


        @livewire('category-filter', ['category' => $category, 'country' => $country])

    </div>

</x-app-layout>
