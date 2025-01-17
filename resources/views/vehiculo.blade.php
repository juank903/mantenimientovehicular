<x-app-layout>
    <div class="mx-auto sm:px-6 lg:px-8 py-10">

        <x-panelformulario lateral="borde">

            <form method="POST" class="flex flex-col md:flex-row gap-4" action="{{ route('vehiculos.create') }}">

                @csrf

                <div class="w-full md:w-1/2 p-4 ">
                    <!-- Marca vehículo -->
                    <div>
                        <x-input-label for="marca" :value="__('Marca')" />
                        <x-text-input id="marca" class="block mt-1 w-full" type="text" name="marca"
                            :value="old('marca')" requiredo autofocus autocomplete="marca" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Placa vehiculo -->
                    <div class="mt-4">
                        <x-input-label for="placa" :value="__('Placa')" />
                        <x-text-input id="placa" class="block mt-1 w-full" type="text" name="placa"
                            :value="old('placa')" requiredo autofocus autocomplete="placa" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Tipo vehículo -->
                    <div class="mt-4">
                        <x-input-label for="tipo" :value="__('Tipo')" />
                        <x-text-input id="tipo" class="block mt-1 w-full" type="text" name="tipo"
                            :value="old('tipo')" requiredo autofocus autocomplete="tipo" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                 </div>


                <div class="w-full md:w-1/2 p-4">


                    <!-- modelo -->
                    <div >
                        <x-input-label for="modelo" :value="__('Modelo')" />
                        <x-text-input id="modelo" class="block mt-1 w-full" type="text" name="modelo"
                            :value="old('modelo')" requiredo autofocus autocomplete="modelo" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Confirme modelo -->
                    <div class="mt-4">
                        <x-input-label for="color" :value="__('Color')" />
                        <x-text-input id="color" class="block mt-1 w-full" type="text" name="color"
                            :value="old('color')" requiredo autofocus autocomplete="color" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="justify-end">
                        {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        href="{{ route('login') }}">
                                        {{ __('Already registered?') }}
                                    </a> --}}

                        <x-primary-button class="mt-4">
                            {{ __('Registrar') }}
                        </x-primary-button>
                    </div>

                </div>

            </form>

        </x-panelformulario>

    </div>

</x-app-layout>
