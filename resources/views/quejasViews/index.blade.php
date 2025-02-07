<x-guest-layout>
    <x-navigation.botonregresar href="{{ route('login') }}" />
    <form method="POST" class="flex flex-col md:flex-row gap-4" action="{{ route('guardar.quejas') }}">
        @csrf
        <div class="w-full md:w-1/2 p-4 ">
            <!-- nombres -->
            <div>
                <x-inputs.input-label for="nombres" :value="__('Ingrese sus nombres')" />
                <x-inputs.text-input-capitalize id="nombres" class="block mt-1 w-full" type="text" name="nombres" :value="old('nombres')"
                    required autofocus autocomplete="nombres" />
                <x-inputs.input-error :messages="$errors->get('nombres')" class="mt-2" />
            </div>
            <!-- apellidos -->
            <div class="mt-4">
                <x-inputs.input-label for="apellidos" :value="__('Ingrese sus apellidos')" />
                <x-inputs.text-input-capitalize id="apellidos" class="block mt-1 w-full" type="text" name="apellidos" :value="old('apellidos')"
                    required autofocus autocomplete="apellidos" />
                <x-inputs.input-error :messages="$errors->get('apellidos')" class="mt-2" />
            </div>
            <x-dependencias/>

        </div>
        <div class="w-full md:w-1/2 p-4">
            <!-- Tipo queja -->
            <div>
                <x-inputs.input-label for="tipoqueja" :value="__('Tipo mensaje')" />
                <x-select required name="tipoqueja" :items="$datosTipo" index="0" />
                <x-inputs.input-error :messages="$errors->get('tipoqueja')" class="mt-2" />
            </div>
            <!-- Detalle mensaje -->
            <div class="mt-4">
                <x-inputs.input-label for="detalle" :value="__('Digite su mensaje')" />
                <textarea required name="detalle" rows="4"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm resize-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Digite su mensaje aquí..."></textarea>
                <x-inputs.input-error :messages="$errors->get('detalle')" class="mt-2" />
            </div>
            <div class="justify-end">
                <x-inputs.primary-button class="mt-4">
                    {{ __('Registrar') }}
                </x-inputs.primary-button>
            </div>
        </div>
    </form>




</x-guest-layout>
