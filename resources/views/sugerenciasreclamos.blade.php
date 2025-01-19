@php
    $datosTipo=['Reclamo','Sugerencia'];
    //dd($arraySubcircuitos->pluck( 'id' ));
@endphp
<x-guest-layout>
    <div class="mx-auto sm:px-6 lg:px-8 py-10">
        <x-panelformulario lateral="borde">
            <form method="POST" class="flex flex-col md:flex-row gap-4" action="{{ route('sugerenciasreclamos') }}">
                @csrf
                <div class="w-full md:w-1/2 p-4 ">
                    <!-- nombres vehículo -->
                    <div>
                        <x-input-label for="nombres" :value="__('Ingrese sus nombres')" />
                        <x-text-input id="nombres" class="block mt-1 w-full" type="text" name="nombres"
                            :value="old('nombres')" requiredo autofocus autocomplete="nombres" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <!-- apellidos vehiculo -->
                    <div class="mt-4">
                        <x-input-label for="apellidos" :value="__('Ingrese sus apellidos')" />
                        <x-text-input id="apellidos" class="block mt-1 w-full" type="text" name="apellidos"
                            :value="old('apellidos')" requiredo autofocus autocomplete="apellidos" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <!-- Subcircuito -->
                    <div class="mt-4">
                        <x-input-label for="subcircuito" :value="__('Elija subcircuito')" />
                        <x-select name="subcircuito" :items="$arraySubcircuitos->pluck( 'nombre_subcircuito_dependencias' )" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                 </div>
                <div class="w-full md:w-1/2 p-4">
                    <!-- Tipo queja -->
                    <div >
                        <x-input-label for="tipoqueja" :value="__('Tipo mensaje')" />
                        <x-select name="tipoqueja" :items="$datosTipo" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <!-- Detalle mensaje -->
                    <div class="mt-4">
                        <x-input-label for="detalle" :value="__('Digite su mensaje')" />
                        {{-- <div class="max-w-md mx-auto p-4"> --}}
                            {{-- <label for="message" class="block text-sm font-medium text-gray-700">Your Message</label> --}}
                            <textarea id="message" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm resize-none focus:ring focus:ring-blue-500 focus:border-blue-500" placeholder="Digite su mensaje aquí..."></textarea>
                        {{-- </div> --}}
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
</x-guest-layout>
