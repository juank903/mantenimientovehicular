<x-app-layout>
    <x-navigation.botonregresar href="{{ route('dashboard') }}" />
    <h1> Vehículo </h1>
    <form id="registrationForm" method="POST" class="flex flex-col md:flex-row flex-wrap gap-4">
        @csrf

        <div class="w-full md:w-1/2 p-4">
            {{-- Vehicle Information --}}
            <div>
                <x-inputs.input-label for="marca_vehiculos" :value="__('Marca Vehículo')" />
                <x-inputs.text-input id="marca_vehiculos" class="block mt-1 w-full" type="text" name="marca_vehiculos"
                    value="{{ $dataVehiculos['marca_vehiculos'] }}" />
                <x-inputs.input-error :messages="$errors->get('marca_vehiculos')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-inputs.input-label for="tipo_vehiculos" :value="__('Tipo Vehículo')" />
                <x-inputs.text-input id="tipo_vehiculos" class="block mt-1 w-full" type="text" name="tipo_vehiculos"
                    value="{{ $dataVehiculos['tipo_vehiculos'] }}" />
                <x-inputs.input-error :messages="$errors->get('tipo_vehiculos')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-inputs.input-label for="modelo_vehiculos" :value="__('Modelo Vehículo')" />
                <x-inputs.text-input id="modelo_vehiculos" class="block mt-1 w-full" type="text"
                    name="modelo_vehiculos" value="{{ $dataVehiculos['modelo_vehiculos'] }}" />
                <x-inputs.input-error :messages="$errors->get('modelo_vehiculos')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-inputs.input-label for="color_vehiculos" :value="__('Color Vehículo')" />
                <x-inputs.text-input id="color_vehiculos" class="block mt-1 w-full" type="text"
                    name="color_vehiculos" value="{{ $dataVehiculos['color_vehiculos'] }}" />
                <x-inputs.input-error :messages="$errors->get('color_vehiculos')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-inputs.input-label for="placa_vehiculos" :value="__('Placa Vehículo')" />
                <x-inputs.text-input id="placa_vehiculos" class="block mt-1 w-full" type="text"
                    name="placa_vehiculos" value="{{ $dataVehiculos['placa_vehiculos'] }}" />
                <x-inputs.input-error :messages="$errors->get('placa_vehiculos')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-inputs.input-label for="kmactual_vehiculos" :value="__('Kilometraje Actual')" />
                <x-inputs.text-input id="kmactual_vehiculos" class="block mt-1 w-full" type="text"
                    name="kmactual_vehiculos" value="{{ $dataVehiculos['kmactual_vehiculos'] }}" />
                <x-inputs.input-error :messages="$errors->get('kmactual_vehiculos')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-inputs.input-label for="combustibleactual_vehiculos" :value="__('Combustible Actual')" />
                <x-inputs.text-input id="combustibleactual_vehiculos" class="block mt-1 w-full" type="text"
                    name="combustibleactual_vehiculos" value="{{ $dataVehiculos['combustibleactual_vehiculos'] }}" />
                <x-inputs.input-error :messages="$errors->get('combustibleactual_vehiculos')" class="mt-2" />
            </div>
        </div>

        <div>
            <x-dependenciasparqueaderos />
            <x-inputs.primary-button type="submit" id="submitButton" class="mt-4">
                {{ __('Registrar') }}
            </x-inputs.primary-button>
        </div>
    </form>
</x-app-layout>
