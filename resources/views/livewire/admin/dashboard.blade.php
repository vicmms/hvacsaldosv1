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
                    <div class="text-2xl font-bold text-gray-100"><span class="text-green-400">139</span> Productos Publicados</div>
                    <div class="flex items-center pt-1">
                        <div class="text-xl font-semibold text-white">con valor total de <span class="text-yellow-300">$9850.90</span></div>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-purple-500 to-blue-700 p-5 bg-white rounded shadow-sm">
                <div>
                    <div class="text-2xl text-gray-100 font-bold"><span class="text-green-400">322</span> Productos en total</div>
                    <div class="flex items-center pt-1">
                        <div class="text-xl font-semibold text-white">con valor acumulado de <span class="text-yellow-300">$29850.90</span></div>
                    </div>
                </div>
            </div>
        </div>
        {{-- charts --}}
        <div class="grid gap-7 sm:grid-cols-3 sm:grid-rows-3 mt-4">
            <div class="p-5 bg-white rounded-md shadow-sm sm:col-span-2 sm:row-span-3">
                <div class="text-2xl text-gray-400 flex">
                    <span class="flex-1">Ventas</span>
                    <div class="text-xs flex self-center">
                        <span class="flex items-center px-2 py-0.5 mx-2 text-green-600 bg-green-100 rounded-full">
                            <i class="fas fa-sort-up"></i> 
                            &nbsp;1.8%
                        </span>
                        <span class="self-center">El último mes</span>
                    </div>
                </div>
                <div class="relative z-10 flex items-center pt-1">
                    <div class="text-2xl font-bold text-gray-900 ">450</div>
                </div>
                <div class="max-w-lg mx-auto pt-4">
                    <div id="chart">
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between p-5 bg-white rounded shadow-sm">
                <div>
                    <div class="text-lg text-gray-500 ">Nuevos Productos Agregados</div>
                    <div class="flex items-center pt-1">
                        <div class="text-xl font-medium text-blue-900 ">3,120</div>
                    </div>
                </div>
                <i class="fas fa-plus-square text-orange-500 text-4xl"></i>
            </div>
            <div class="flex items-center justify-between p-5 bg-white rounded shadow-sm">
                <div>
                    <div class="text-lg text-gray-500 ">Nuevos Usuarios</div>
                    <div class="flex items-center pt-1">
                        <div class="text-xl font-medium text-blue-900 ">32</div>
                    </div>
                </div>
                <i class="fas fa-user-plus text-orange-500 text-4xl"></i>
            </div>
            <div class="flex items-center justify-between p-5 bg-white rounded shadow-sm">
                <div>
                    <div class="text-lg text-gray-500 ">Nuevos Usuarios</div>
                    <div class="flex items-center pt-1">
                        <div class="text-xl font-medium text-blue-900 ">32</div>
                    </div>
                </div>
                <i class="fas fa-user-plus text-orange-500 text-4xl"></i>
            </div>
        </div>
    </div>
    @push('script')
        <script src="{{ asset('js/charts.js') }}"></script>
    @endpush
</div>
