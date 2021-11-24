<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-700">

    <h1 class="text-3xl text-center font-semibold mb-8">Complete esta información para crear un producto</h1>
    <div class="grid grid-cols-2 gap-6 mb-4">

        {{-- Categoría --}}
        <div>
            <x-jet-label value="Categorías*" />
            <select class="w-full form-control" wire:model="category_id">
                <option value="" selected disabled>Seleccione una categoría</option>

                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            <x-jet-input-error for="category_id" />
        </div>

        {{-- Subcategoría --}}
        <div>
            <x-jet-label value="Subcategorías*" />
            <select class="w-full form-control" wire:model="subcategory_id">
                <option value="" selected disabled>Seleccione una subcategoría</option>

                @foreach ($subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                @endforeach
            </select>

            <x-jet-input-error for="subcategory_id" />
        </div>
    </div>

    {{-- Nombre --}}
    <div class="mb-4">
        <x-jet-label value="Nombre*" />
        <x-jet-input type="text" class="w-full" wire:model="name" placeholder="Ingrese el nombre del producto" />
        <x-jet-input-error for="name" />
    </div>

    {{-- Slug --}}
    <div class="mb-4 hidden">
        <x-jet-label value="Slug" />
        <x-jet-input type="text" disabled wire:model="slug" class="w-full bg-gray-200"
            placeholder="Ingrese el slug del producto" />

        <x-jet-input-error for="slug" />
    </div>

    <div class="grid grid-cols-2 gap-6 mb-4">

        {{-- Modelo --}}
        <div>
            <x-jet-label value="Modelo*" />
            <x-jet-input type="text" class="w-full" wire:model="model"
                placeholder="Ingrese el modelo del producto" />
            <x-jet-input-error for="model" />
        </div>

        {{-- Numero de serie --}}
        <div>
            <x-jet-label value="No. Serie" />
            <x-jet-input type="text" class="w-full" wire:model="serie_number"
                placeholder="Ingrese el no. de serie del producto" />
            {{-- <x-jet-input-error for="serie_number" /> --}}
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6 mb-4">
        {{-- Precio --}}
        <div>
            <x-jet-label value="Precio de venta en Saldo HVAC*" />
            <x-jet-input wire:model="price" type="text" class="w-full formatter" step="1" onkeyup="formatter(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
            <x-jet-input-error for="price" />
        </div>

        {{-- Precio commercial --}}
        <div>
            <x-jet-label value="Precio comercial*" />
            <x-jet-input wire:model="commercial_price" type="text" class="w-full formatter" step="1" onkeyup="formatter(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
            <x-jet-input-error for="commercial_price" />
        </div>

        {{-- moneda --}}
        <div>
            <x-jet-label value="Moneda*" />
            <select class="w-full form-control" wire:model="currency_id">
                <option value="" selected disabled>Seleccione una moneda</option>

                @foreach ($currencies as $currency)
                    <option value="{{ $currency->id }}">{{ $currency->currency .  $currency->symbol}}</option>
                @endforeach
            </select>

            <x-jet-input-error for="currency_id" />
        </div>
    </div>
    <div class="grid grid-cols-2 gap-6 mb-4">
        {{-- cantidad --}}
        <div>
            <x-jet-label value="Cantidad*" />
            <x-jet-input wire:model="quantity" type="number" class="w-full" />
            <x-jet-input-error for="quantity" />
        </div>
        {{-- unidad --}}
        <div>
            <x-jet-label value="Unidad*" />
            <x-jet-input wire:model="unit" type="text" class="w-full" placeholder="pza, paquete, caja, etc."/>
            <x-jet-input-error for="unit" />
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-4">
        {{-- Marca --}}
        <div>
            <x-jet-label value="Marca*" />
            <select class="form-control w-full" wire:model="brand_id">
                <option value="" selected disabled>Seleccione una marca</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>

            <x-jet-input-error for="brand_id" />
        </div>

        {{-- Envio disponible --}}
        <div>
            <x-jet-label value="Envio disponible*" />
            <select class="form-control w-full" wire:model="shipping">
                <option value="0">No</option>
                <option value="1">Si</option>
            </select>

            <x-jet-input-error for="shipping" />
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-4">
        {{-- Pais / estado --}}
        <div>
            <x-jet-label value="Selecciona un estado ({{ $user->country->name }})*" />
            <select class="form-control w-full" wire:model="state_id">
                <option value="" selected disabled>Seleccione un estado</option>
                @foreach ($user->country->states()->orderBy('name', 'asc')->get() as $state)
                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
            </select>

            {{-- <x-jet-input-error for="country_id" /> --}}
        </div>
        <div>
            <x-jet-label value="Ciudad/Localidad*" />
            <x-jet-input type="text" class="w-full" wire:model="city" placeholder="Nombre completo" />
            <x-jet-input-error for="city" />
        </div>
    </div>

    {{-- Descrición --}}
    <div class="mb-4">
        <div wire:ignore>
            <x-jet-label value="Descripción*" />
            <textarea class="w-full form-control" rows="4" wire:model="description" x-data>
            </textarea>
        </div>
        <x-jet-input-error for="description" />
    </div>


    <div class="flex mt-4">
        <x-jet-button wire:loading.attr="disabled" wire:target="save" wire:click="save" class="ml-auto">
            Crear producto
        </x-jet-button>
    </div>
</div>
