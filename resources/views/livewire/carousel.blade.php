{{-- <div>

    <div class="flexslider">
        <ul class="slides">
            @foreach ($images as $image)
                <li>
                    <img src="{{ asset($image->url) }}" />
                </li>
            @endforeach
        </ul>
    </div>

    @push('script')

        <script>
            Livewire.on('showModalImages', pivot => {
                console.log('show')
                $('.flexslider').flexslider({
                    animation: "slide"
                });
            });
        </script>
    @endpush
</div> --}}
