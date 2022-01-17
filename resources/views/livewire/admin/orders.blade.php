<div class="container py-12">

    {{-- <div class="flex mb-6">
        <button class="text-lg px-4 py-2 font-semibold rounded-sm {{$type==1 ? 'bg-orange-500 text-white' : ''}}" wire:click="$set('type',1)">Mis Compras</button>
        <button class="text-lg px-4 py-2 font-semibold rounded-sm {{$type==2 ? 'bg-orange-500 text-white' : ''}}" wire:click="$set('type',2)">Mis Ventas</button>
    </div> --}}

    <section class="grid grid-cols-6 gap-6 text-white">
        <a href="{{ route('admin.orders.index') }}" class="bg-blue-500 bg-opacity-75 rounded-lg pt-8 pb-4">
            <p class="text-center text-2xl">
                {{ $todos }}
            </p>
            <p class="uppercase text-center">Todos</p>
            <p class="text-center text-2xl mt-2">
                <i class="fas fa-business-time"></i>
            </p>
        </a>

        <a href="{{ route('admin.orders.index') . '?status=2' }}"
            class="bg-gray-500 bg-opacity-75 rounded-lg pt-8 pb-4">
            <p class="text-center text-2xl">
                {{ $solicitudes }}
            </p>
            <p class="uppercase text-center">Solicitudes</p>
            <p class="text-center text-2xl mt-2">
                <i class="fas fa-plus-circle"></i>
            </p>
        </a>

        <a href="{{ route('admin.orders.index') . '?status=3' }}"
            class="bg-yellow-500 bg-opacity-75 rounded-lg pt-8 pb-4">
            <p class="text-center text-2xl">
                {{ $pagados }}
            </p>
            <p class="uppercase text-center">Pagados</p>
            <p class="text-center text-2xl mt-2">
                <i class="fas fa-credit-card"></i>
            </p>
        </a>

        <a href="{{ route('admin.orders.index') . '?status=6' }}"
            class="bg-orange-500 bg-opacity-75 rounded-lg pt-8 pb-4">
            <p class="text-center text-2xl">
                {{ $camino }}
            </p>
            <p class="uppercase text-center">En camino</p>
            <p class="text-center text-2xl mt-2">
                <i class="fas fa-truck"></i>
            </p>
        </a>

        <a href="{{ route('admin.orders.index') . '?status=4' }}"
            class="bg-green-500 bg-opacity-75 rounded-lg pt-8 pb-4">
            <p class="text-center text-2xl">
                {{ $entregados }}
            </p>
            <p class="uppercase text-center">Entregados</p>
            <p class="text-center text-2xl mt-2">
                <i class="fas fa-check-circle"></i>
            </p>
        </a>

        <a href="{{ route('admin.orders.index') . '?status=5' }}"
            class=" bg-red-500 bg-opacity-75 rounded-lg pt-8 pb-4">
            <p class="text-center text-2xl">
                {{ $cancelados }}
            </p>
            <p class="uppercase text-center">Cancelados</p>
            <p class="text-center text-2xl mt-2">
                <i class="fas fa-times-circle"></i>
            </p>
        </a>
    </section>

    @if ($orders->count())

        <section class="bg-white shadow-lg rounded-lg px-12 py-8 mt-12 text-gray-700">
            <h1 class="text-2xl mb-4">Pedidos recientes</h1>
            <ul>
                @foreach ($orders as $order)
                    <li>
                        <a href="{{ route('admin.orders.show', $order) }}"
                            class="flex items-center py-2 px-4 hover:bg-gray-100 {{ count(Auth::user()->roles->pluck('name')) ? '' : 'pointer-events-none' }}">
                            <span class="w-12 text-center">
                                @switch($order->status)
                                    @case(1)
                                        <i class="fas fa-business-time text-red-500 opacity-50"></i>
                                    @break
                                    @case(2)
                                        <i class="far fa-bell text-gray-500 opacity-50"></i>
                                    @break
                                    @case(3)
                                        <i class="fas fa-credit-card text-yellow-500 opacity-50"></i>
                                    @break
                                    @case(4)
                                        <i class="fas fa-check-circle text-green-500 opacity-50"></i>
                                    @break
                                    @case(5)
                                        <i class="fas fa-times-circle text-red-500 opacity-50"></i>
                                    @break
                                    @case(6)
                                        <i class="fas fa-truck text-orange-500 opacity-50"></i>
                                    @break
                                    @default

                                @endswitch
                            </span>

                            <span>
                                Producto: {{ json_decode($order->content)->name }}
                                <br>
                                {{ $order->created_at->format('d/m/Y') }}
                            </span>


                            <div class="ml-auto">
                                <span class="font-bold">
                                    @switch($order->status)
                                        @case(1)

                                            Pendiente

                                        @break
                                        @case(2)

                                            Solicitud

                                        @break
                                        @case(3)

                                            Pagado

                                        @break
                                        @case(4)

                                            Entregado

                                        @break
                                        @case(5)

                                            Cancelado

                                        @break
                                        @case(6)

                                            En camino

                                        @break
                                        @default

                                    @endswitch
                                </span>

                                <br>

                                <span class="text-sm">
                                    {{ json_decode($order->content)->options->currency ? json_decode($order->content)->options->currency : '$' }}
                                    {{ number_format($order->total, 0, '.', ',') }}
                                </span>
                            </div>

                            <span>
                                <i class="fas fa-angle-right ml-6"></i>
                            </span>

                        </a>
                    </li>
                @endforeach
            </ul>
        </section>

    @else
        <div class="bg-white shadow-lg rounded-lg px-12 py-8 mt-12 text-gray-700">
            <span class="font-bold text-lg">
                No existe registros de ordenes
            </span>
        </div>
    @endif

</div>
