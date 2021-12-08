<div>
    <x-jet-dropdown width="96">
        <x-slot name="trigger">
            <span class="relative inline-block cursor-pointer">
                @if ($notifications->number)
                    <span class="absolute left-2 bottom-3 bg-red-500 text-white rounded-full text-xs px-1">
                        {{ $notifications->number == 10 ? 9 . '+' : $notifications->number }}
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
                    <li class="p-2 border-b border-gray-200 cursor-pointer {{ $notification->read ? '' : 'bg-blue-50' }}"
                        wire:click="readNotification({{ $notification->id }})">
                        <div class="flex mb-1">
                            @if ($notification->image_url)
                                @if (app\Models\Product::where('id', $notification->product_id)->where('user_id', Auth::user()->id)->count())
                                    <a href="{{ asset('admin/products/' . $notification->product_slug . '/edit') }}">
                                        <img src="{{ asset($notification->image_url) }}"
                                            class="shadow-sm rounded-full w-11 h-11 object-cover mx-2"
                                            alt="{{ $notification->product_name }}">
                                    </a>
                                @else
                                    <img src="{{ asset($notification->image_url) }}"
                                        class="shadow-sm rounded-full w-11 h-11 object-cover mx-2"
                                        alt="{{ $notification->product_name }}">
                                @endif
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
                            @if (!$notification->read)
                                <i class="fas fa-circle text-blue-900" style="font-size: 8px"></i>
                            @endif
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

                @if ($notifications->count())
                    <div class="py-2 px-3 flex">
                        <x-button-enlace href="{{ route('admin.notifications') }}" color="orange" class="felx-1 mr-2">
                            Todas las notificaciones
                        </x-button-enlace>
                        <x-jet-button wire:click="clearNotifications">
                            Limpiar
                        </x-jet-button>
                    </div>
                @endif


            </x-slot>
        </x-jet-dropdown>
    </div>
