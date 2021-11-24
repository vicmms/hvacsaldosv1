<div>
    <x-jet-dropdown width="96">
        <x-slot name="trigger">
            <span class="relative inline-block cursor-pointer">
                @if ($notifications->count())
                    <span class="absolute left-2 bottom-3 bg-red-500 text-white rounded-full text-xs px-1">
                        {{ $notifications->count() == 10 ?  9 . "+" : $notifications->count() }}
                    </span>
                    <i class="fas fa-bell text-xl mt-1"></i>
                @else
                    <i class="fas fa-bell text-xl mt-1"></i>
                @endif
            </span>
        </x-slot>

        <x-slot name="content">
            <ul class="max-h-96 overflow-y-scroll">
                @forelse ($notifications as $notification)
                    <li class="p-2 border-b border-gray-200">
                        <div class="flex mb-1">
                            @if ($notification->image_url)
                                <a href="{{asset('admin/products/'.$notification->product_slug.'/edit')}}">
                                    <img src="{{asset($notification->image_url)}}" class="w-11 max-h-12 object-cover mx-2" alt="{{$notification->product_name}}">
                                </a>
                            @endif
                            <p class="flex-1">{!! $notification->notification !!}</p>
                        </div>
                        @if (strtotime(date('Y-m-d H:i:s')) - strtotime($notification->created_at) < 60)
                            <p class="text-right text-gray-700">Hace {{ round(strtotime(date('Y-m-d H:i:s')) - strtotime($notification->created_at)) }}
                                segundos.</p>
                        @else
                            @if (strtotime(date('Y-m-d H:i:s')) - strtotime($notification->created_at) < 3600)
                                <p class="text-right text-gray-700">Hace
                                    {{ round((strtotime(date('Y-m-d H:i:s')) - strtotime($notification->created_at)) / 60) }}
                                    minutos.</p>
                            @else
                                @if (strtotime(date('Y-m-d H:i:s')) - strtotime($notification->created_at) < 86400)
                                    <p class="text-right text-gray-700">Hace
                                        {{ round((strtotime(date('Y-m-d H:i:s')) - strtotime($notification->created_at)) / 3600) }}
                                        horas.</p>
                                @else
                                    <p class="text-right text-gray-700">Hace
                                        {{ round((strtotime(date('Y-m-d H:i:s')) - strtotime($notification->created_at)) / 86400) }}
                                        dias.</p>
                                @endif
                            @endif
                        @endif
                    </li>
                @empty
                    <li class="py-6 px-4">
                        <p class="text-center text-gray-700">
                            No hay notificaciones
                        </p>
                    </li>
                @endforelse
            </ul>

            @if ($notifications->count())
                <div class="py-2 px-3">

                    <x-button-enlace href="{{ route('shopping-cart') }}" color="orange" class="w-full">
                        Ver todas las notificaciones
                    </x-button-enlace>

                </div>
            @endif


        </x-slot>
    </x-jet-dropdown>
</div>
