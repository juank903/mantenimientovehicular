<x-app-layout>
    <x-navigation.botonregresar href="{{ route('dashboard') }}" />
    <form id="asistenciaForm" method="POST" class="flex flex-col md:flex-row gap-4"
        action="{{ route('registroasistencia.store') }}">
        @csrf
        <div class="w-full md:w-1/2 p-4 ">
            <div class="flex gap-4">
                <div class="w-full">
                    <input type="hidden" id="personalpolicia_id" name="personalpolicia_id"
                        value="{{ $userId }}"></input>
                    <input type="hidden" id= "tipoInput" name="tipoInput" value="{{ $tipoInput }}"></input>
                    <x-inputs.input-label for="personalpolicia_codigo" :value="__('Ingrese Codigo único')" />
                    <x-inputs.text-input-capitalize id="personalpolicia_codigo" class="block mt-1 w-full" type="text"
                        name="personalpolicia_codigo" :value="old('personalpolicia_codigo')" required autofocus
                        autocomplete="personalpolicia_codigo" />
                    <x-inputs.input-error :messages="$errors->get('personalpolicia_codigo')" class="mt-2" />
                    <x-inputs.input-error :messages="$errors->get('personalpolicia_id')" class="mt-2" />
                    <x-inputs.input-error :messages="$errors->get('tipoInput')" class="mt-2" />
                </div>
                <x-inputs.primary-button type="submit" id="submitButton" class="mt-4">
                    {{ __('Registrar') }}
                </x-inputs.primary-button>
            </div>
        </div>
    </form>
</x-app-layout>
