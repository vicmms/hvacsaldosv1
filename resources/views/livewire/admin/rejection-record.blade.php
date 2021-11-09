<div class="bg-white shadow-xl rounded-lg p-6 mb-4 max-h-96 overflow-scroll">
    <p class="text-2xl text-center font-semibold mb-2">Historial de rechazos</p>

    @foreach ($rejections as $rejection)
        <div class="my-4 bg-gray-100 rounded-xl p-4">
            <span>{{explode(" ", $rejection->created_at)[0]}}</span>
            <p>{{$rejection->message}}</p>
        </div>
    @endforeach

</div>