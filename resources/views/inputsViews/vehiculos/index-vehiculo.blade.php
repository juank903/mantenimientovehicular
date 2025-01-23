@php
    $datosPrioridad = ['Alta', 'Baja'];
    $datosTipoVehiculo = ['Moto', 'Auto', 'Camioneta'];
    $datosDefault = [''];
@endphp

<x-app-layout>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="mx-auto sm:px-6 lg:px-8 py-10">
        <x-panelformulario lateral="borde">
            <form method="POST" class="flex flex-col md:flex-row gap-4" action="{{ route('guardarsolicitudvehiculo') }}">
                @csrf
                <div class="w-full md:w-1/2 p-4 ">
                    <!-- nombres -->
                    <div>
                        <x-input-label for="nombres" :value="__('Solicitud de:')" />
                        <x-text-input class="block mt-1 w-full" type="text"
                            name="nombres"
                            value="{{ session('personal')['primerapellido_personal_policias'] .
                                ' ' .
                                session('personal')['segundoapellido_personal_policias'] .
                                ' ' .
                                session('personal')['primernombre_personal_policias'] .
                                ' ' .
                                session('personal')['segundonombre_personal_policias'] }}"
                            disabled="true" />
                        <!-- Campo de entrada para el ID -->
                        <input type="hidden" name="id" value="{{ session('personal')['id'] }}">
                        <!-- Reemplaza 12345 con el ID que deseas pasar -->
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <!-- Subcircuito -->
                    <div class="mt-4">
                        <x-input-label for="subcircuito" :value="__('Pertenece al Subcircuito')" />
                        <x-text-input id="subcircuito" class="block mt-1 w-full" type="text" name="subcircuito"
                            value="{{ session('subcircuito') }}" disabled="true" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                </div>
                <div class="w-full md:w-1/2 p-4">
                    <!-- Fecha requerida -->
                    <div class="mb-4">
                        <x-input-label for="fecharequerimiento" :value="__('Seleccione fecha para requerimiento del vehículo')" />
                        <input class="text-xs" type="date" id="fecharequerimiento" name="fecharequerimiento"
                            required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <!-- Tipo prioridad -->
                    <div class="mt-4">
                        <x-input-label for="prioridad" :value="__('Prioridad')" />
                        <x-select required name="prioridad" :items="$datosPrioridad" index="0" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Tipo vehiculo-->
                    <div>
                        <x-input-label for="tipo" :value="__('Tipo Vehículo')" />
                        <x-select required name="tipo" :items="$datosTipoVehiculo" index="0" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Detalle mensaje -->
                    <div class="mt-4">
                        <x-input-label for="detalle" :value="__('Razón de solicitud')" />
                        {{-- <div class="max-w-md mx-auto p-4"> --}}
                        {{-- <label for="message" class="block text-sm font-medium text-gray-700">Your Message</label> --}}
                        <textarea required name="detalle" rows="4"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm resize-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Digite su mensaje aquí..."></textarea>
                        {{-- </div> --}}
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
