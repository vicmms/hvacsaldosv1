<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Usuarios
        </h2>
    </x-slot>

    <div class="container py-12">
        <x-table-responsive>

            <div class="px-6 py-4">

                <x-jet-input wire:model="search" type="text" class="w-full"
                    placeholder="Escriba algo para filtrar" />

            </div>

            @if (count($users))

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rol
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cambiar Rol
                            </th>
                            <th scope="col"
                                class="text-center px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Eliminar
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">

                        @foreach ($users as $user)

                            <tr wire:key="{{ $user->email }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-gray-900">
                                        {{ $user->id }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">

                                    <div class="text-sm text-gray-900">
                                        {{ $user->name }}
                                    </div>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $user->email }}
                                    </div>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="text-sm text-gray-900">

                                        @if (count($user->roles))
                                            Admin
                                        @else
                                            No tiene rol
                                        @endif

                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <label>
                                        <input {{ $user->getRolenames()->first() == 'admin' ? 'checked' : '' }}
                                            value="2" type="radio" name="{{ $user->email }}"
                                            wire:change="assignRole({{ $user->id }}, $event.target.value)">
                                        SP Admin
                                    </label>
                                    <label>
                                        <input {{ $user->getRolenames()->first() == 'user' ? 'checked' : '' }}
                                            value="1" type="radio" name="{{ $user->email }}"
                                            wire:change="assignRole({{ $user->id }}, $event.target.value)">
                                        Admin
                                    </label>

                                    <label class="ml-2">
                                        <input {{ count($user->roles) ? '' : 'checked' }} value="0" type="radio"
                                            name="{{ $user->email }}"
                                            wire:change="assignRole({{ $user->id }}, $event.target.value)">
                                        No
                                    </label>
                                </td>
                                <td class="text-center">
                                    <i wire:click="$emit('delete', {{ $user }})" class="fas fa-trash text-red-400 hover:text-red-600 cursor-pointer"></i>
                                </td>
                            </tr>

                        @endforeach
                        <!-- More people... -->


                    </tbody>
                </table>

            @else
                <div class="px-6 py-4">
                    No hay ningún registro coincidente
                </div>
            @endif

            @if ($users->hasPages())

                <div class="px-6 py-4">
                    {{ $users->links() }}
                </div>

            @endif
        </x-table-responsive>
    </div>

    @push('script')
    <script>
        Livewire.on('delete', (user) => {
            Swal.fire({
                title: '¿Eliminar al usuario "' + user['name'] + '" ?',
                text: "Se perderá toda la información relacionada con este usuario!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('admin.user-component', 'deleteUser', user);

                    Swal.fire({
                        title: 'Usuario eliminado exitosamente',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1000,
                    })
                }
            })

        });
    </script>
    @endpush
</div>
