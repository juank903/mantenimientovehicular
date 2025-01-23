{{-- <p>El parámetro recibido es: {{ $id }}</p> --}}
<x-app-layout>
    <div class="mx-auto sm:px-6 lg:px-8 py-10">

        <x-panelformulario lateral="borde">

            <form method="POST" class="flex flex-col md:flex-row gap-4" action="{{ route('vehiculos.create') }}">

                @csrf

                <div class="w-full md:w-1/2 p-4 ">
                    <!-- responsable vehículo -->
                    <div>
                        <x-input-label for="responsable" :value="__('Responsable')" />
                        <x-text-input id="responsable" class="block mt-1 w-full" type="text" name="responsable"
                            value="{{ Auth::user()->name }}" disabled="disabled" />

                    </div>
                    <!-- Marca vehículo -->
                    <div class="mt-4">
                        <x-input-label for="marca" :value="__('Marca')" />
                        <x-text-input id="marca" class="block mt-1 w-full" type="text" name="marca"
                            :value="$vehiculo->marca_vehiculos" disabled="disabled" />
                    </div>

                    <!-- Placa vehiculo -->
                    <div class="mt-4">
                        <x-input-label for="placa" :value="__('Placa')" />
                        <x-text-input id="placa" class="block mt-1 w-full" type="text" name="placa"
                            :value="$vehiculo->placa_vehiculos" disabled="disabled" />
                    </div>

                    <!-- Tipo vehículo -->
                    <div class="mt-4">
                        <x-input-label for="tipo" :value="__('Tipo')" />
                        <x-text-input id="tipo" class="block mt-1 w-full" type="text" name="tipo"
                            :value="$vehiculo->tipo_vehiculos" disabled="disabled" />

                    </div>
                    <!-- modelo -->
                    <div class="mt-4">
                        <x-input-label for="modelo" :value="__('Modelo')" />
                        <x-text-input id="modelo" class="block mt-1 w-full" type="text" name="modelo"
                            :value="$vehiculo->modelo_vehiculos" disabled="disabled" />
                    </div>

                    <!-- color -->
                    <div class="mt-4">
                        <x-input-label for="color" :value="__('Color')" />
                        <x-text-input id="color" class="block mt-1 w-full" type="text" name="color"
                            :value="$vehiculo->color_vehiculos" disabled="disabled" />
                    </div>

                </div>


                <div class="w-full md:w-1/2 p-4">

                    <!-- fecha solicitud -->
                    <div>
                        <x-input-label for="fechasolicitud" :value="__('Fecha Solicitud')" />
                        @php
                            $date = new \DateTime()
                        @endphp
                        <x-text-input id="fechasolicitud" class="block mt-1 w-full" type="text" name="fechasolicitud"
                            :value="date_format($date, 'Y-m-d')" disabled="disabled" />
                    </div>

                    <!-- fecha solicitud -->
                    <div class="mt-4">
                        <x-input-label for="horasolicitud" :value="__('Hora Solicitud')" />
                        <x-text-input id="horasolicitud" class="block mt-1 w-full" type="text" name="horasolicitud"
                            :value="date_format($date, 'G:ia')" disabled="disabled" />
                    </div>

                    <!-- Segundo Nombre -->
                    <div class="mt-4">
                        <x-input-label for="kilometrajeactual" :value="__('Kilometraje actual')" />
                        <x-text-input id="kilometrajeactual" class="block mt-1 w-full" type="text" name="kilometrajeactual"
                            :value="old('kilometrajeactual')" requiredo autofocus autocomplete="kilometrajeactual" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="justify-end">
                        {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        href="{{ route('login') }}">
                                        {{ __('Already registered?') }}
                                    </a> --}}

                        <x-primary-button class="mt-4">
                            {{ __('Solicitar') }}
                        </x-primary-button>
                    </div>

                </div>

            </form>

        </x-panelformulario>

    </div>

</x-app-layout>
