<div>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                Todas las notificaciones
            </h2>
        </div>
    </x-slot>

    <div class="container py-12 bg-white mt-6 rounded-b-3xl shadow-md">
            <ul class="overflow-y-scroll w-full" style="max-height: 600px;">
                @forelse ($notifications as $notification)
                    <li class="p-2 border-b border-gray-200">
                        <div class="flex mb-1">
                            @if ($notification->image_url)
                                <a href="{{ asset('admin/products/' . $notification->product_slug . '/edit') }}">
                                    <img src="{{ asset($notification->image_url) }}"
                                        class="shadow-sm rounded-full w-11 max-h-12 object-cover mx-2"
                                        alt="{{ $notification->product_name }}">
                                </a>
                            @else
                                @switch($notification->icon)
                                    @case(1)
                                        <i class="fas fa-check-circle text-4xl mx-2 text-green-600"></i>
                                    @break
                                    @case(2)
                                        <i class="fas fa-exclamation-circle text-4xl mx-2 text-blue-600"></i>
                                    @break
                                    @default
                                        <i class="fas fa-flag text-4xl mx-2 text-blue-900"></i>
                                @endswitch
                            @endif
                            <p class="flex-1">{!! $notification->notification !!}</p>
                        </div>
                        @if (strtotime(date('Y-m-d H:i:s')) - strtotime($notification->created_at) < 60)
                            <p class="text-right text-gray-700">Hace
                                {{ round(strtotime(date('Y-m-d H:i:s')) - strtotime($notification->created_at)) }}
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
    </div>
</div>
