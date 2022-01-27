<div>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                Dashboard
            </h2>
        </div>
    </x-slot>
    <div class="container py-12">
        {{-- cards --}}
        <div class="grid gap-7 sm:grid-cols-2">
            <div class="bg-gradient-to-l from-purple-500 to-blue-700 p-5 bg-white rounded shadow-sm">
                <div class="">
                    <div class="text-2xl font-bold text-gray-100"><span class="text-green-400">{{count($publishedProducts)}}</span> Productos Publicados</div>
                    <div class="flex items-center pt-1">
                        <div class="text-lg font-semibold text-white">con valor total de 
                            @foreach ($money_by_country_published as $key => $currency)
                                <span class="text-yellow-300 font-bold">{{$currency['currency'] . ' $' . number_format($currency['amount'], 0, '.', ',')}} {{($key + 1) == count($money_by_country_published) ? '' : ' + ' }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-purple-500 to-blue-700 p-5 bg-white rounded shadow-sm">
                <div>
                    <div class="text-2xl text-gray-100 font-bold"><span class="text-green-400">{{count($allProducts)}}</span> Productos en total</div>
                    <div class="flex items-center pt-1">
                        <div class="text-lg font-semibold text-white">con valor acumulado de 
                            @foreach ($money_by_country_all as $key => $currency)
                                <span class="text-yellow-300 font-bold">{{$currency['currency'] . ' $' . number_format($currency['amount'], 0, '.', ',')}} {{($key + 1) == count($money_by_country_all) ? '' : ' + ' }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- charts --}}
        <div class="grid gap-7 sm:grid-cols-3 sm:grid-rows-4 mt-4">
            <div class="p-5 bg-white rounded-md shadow-sm sm:col-span-2 sm:row-span-3">
                <div class="text-2xl text-gray-400 flex">
                    <span class="flex-1">Total de Ventas</span>
                    <div class="text-xs flex self-center">
                        <span class="flex items-center px-2 py-0.5 mx-2 {{$increase > 0 ? 'text-green-600 bg-green-100' : 'text-red-600 bg-red-100'}}  rounded-full">
                            <i class="fas {{$increase > 0 ? 'fa-sort-up' : 'fa-sort-down'}}"></i> 
                            &nbsp;{{$increase}}%
                        </span>
                        <span class="self-center" id="increase_label"></span>
                    </div>
                </div>
                <div class="relative z-10 flex items-center pt-1">
                    <div class="text-2xl font-bold text-gray-900 ">{{count($totalSales)}}</div>
                </div>
                <div class="max-w-lg mx-auto pt-4 text-center">
                    <div id="chart">
                    </div>
                    <p class="text-md text-gray-500"><span id="last_sales_label"></span> <span class="font-semibold" id="last_sales"></span></p>
                </div>
            </div>
            <div class="flex items-center justify-between p-5 bg-white rounded shadow-sm">
                <div class="w-full">
                    <h2 class="text-lg text-gray-500 ">Filtro</h2>
                    <select name="" id="" class="border-none focus:ring-0 bg-gray-100 w-11/12 rounded-sm" wire:model="filter">
                        <option value="1">Última Semana</option>
                        <option value="2">Último Mes</option>
                        <option value="3">Último año</option>
                    </select>
                </div>
                <i class="fas fa-calendar-day text-orange-500 text-4xl"></i>
            </div>
            <div class="flex items-center justify-between p-5 bg-white rounded shadow-sm">
                <div>
                    <div class="text-lg text-gray-500 ">Nuevos Productos Agregados a Saldo HVAC</div>
                    <div class="flex items-center pt-1">
                        <div class="text-xl font-medium text-blue-900 ">{{count($newProducts)}}</div>
                    </div>
                </div>
                <i class="fas fa-plus-square text-orange-500 text-4xl"></i>
            </div>
            <div class="flex items-center justify-between p-5 bg-white rounded shadow-sm">
                <div>
                    <div class="text-lg text-gray-500 ">Nuevos Usuarios</div>
                    <div class="flex items-center pt-1">
                        <div class="text-xl font-medium text-blue-900 ">{{count($newUsers)}}</div>
                    </div>
                </div>
                <i class="fas fa-user-plus text-orange-500 text-4xl"></i>
            </div>
        </div>
        
    </div>
    @push('script')
        <script src="{{ asset('js/charts.js') }}"></script>
        <script>
            Livewire.on('repaintChart', (data, type) => {
                paintSalesChart(data, type)
            })
        </script>
    @endpush
</div>
