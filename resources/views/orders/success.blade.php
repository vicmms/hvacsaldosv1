<x-app-layout>

    <div class="container py-12">

        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-2">
                <h2 class="text-2xl font-bold mb-4">Se ha solicitado la compra correctamente</h2>
                <p class="text-lg  mb-8">
                    Nos estaremos comunicando por medio de esta plataforma y por correo electronico
                    para que el pago sea realizado y la compra pueda ser completada, mantengase al
                    pendiente por estos medios para que la compra pueda ser procesada lo más pronto
                    posible.
                </p>
                <div class="flex">
                    <a href="{{ route('orders.index') }}">
                        <x-jet-button class="mr-4">
                            Ver mis pedidos
                        </x-jet-button>
                    </a>
                    <x-jet-secondary-button>
                        <a href="/">Inicio</a>
                    </x-jet-secondary-button>
                </div>
            </div>
            <div class="mx-auto">
                <img class="w-40 object-cover object-center"
                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e0/Check_green_icon.svg/1200px-Check_green_icon.svg.png"
                    alt="">
            </div>
        </div>

    </div>

</x-app-layout>
