<x-app-layout>
    <x-navigation.botonregresar href="{{ route('dashboard') }}" />
    <div class="px-4 py-1 sm:px-6">
        <h2 class="text-xl leading-8 font-medium text-gray-900">
            Solicitud Vehicular<br />
        </h2>
    </div>

    <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
        <dl class="sm:divide-y sm:divide-gray-200">
            <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Elaborado por
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $policia['apellido_paterno'] }}&nbsp
                    {{ $policia['apellido_materno'] }}&nbsp
                    {{ $policia['primer_nombre'] }}&nbsp
                    {{ $policia['segundo_nombre'] }}
                </dd>
            </div>

            <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Ubicación del solicitante
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <span class="text-xs text-gray-600">Subcircuito: </span> {{ $policia['subcircuito'] }}&nbsp /
                    <span class="text-xs text-gray-600">Circuito: </span> {{ $policia['circuito'] }}&nbsp /
                    <span class="text-xs text-gray-600">Distrito: </span>{{ $policia['distrito'] }}&nbsp /
                    <span class="text-xs text-gray-600">Provincia: </span>{{ $policia['provincia'] }}
                </dd>
            </div>
            <form method="POST" action="{{ route('solicitudvehiculo.store') }}">
                @csrf
                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Fecha requerimiento del vehículo - desde
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <div class="relative">
                            <input type="text" class="fechas input input-floating peer max-w-sm"
                                placeholder="YYYY-MM-DD" name="fecharequerimientodesde" id="fecharequerimientodesde" />
                            <x-inputs.input-error :messages="$errors->get('fecharequerimientodesde')" class="mt-2" />
                            <input type="text" class="input max-w-sm" placeholder="HH:MM" id="horarequerimientodesde"
                                name="horarequerimientodesde" />
                            <x-inputs.input-error :messages="$errors->get('horarequerimientodesde')" class="mt-2" />
                        </div>
                    </dd>
                </div>
                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Fecha requerimiento del vehículo - hasta
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <div class="relative">
                            <input type="text" class="fechas input input-floating peer max-w-sm"
                                placeholder="YYYY-MM-DD" name="fecharequerimientohasta" id="fecharequerimientohasta" />
                            <x-inputs.input-error :messages="$errors->get('fecharequerimientohasta')" class="mt-2" />
                            <input type="text" class="input max-w-sm" placeholder="HH:MM" id="horarequerimientohasta"
                                name="horarequerimientohasta" />
                            <x-inputs.input-error :messages="$errors->get('horarequerimientohasta')" class="mt-2" />
                        </div>
                    </dd>
                </div>
                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Jornada laboral
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <div>
                            <x-select required name="jornada" :items="$jornadas" index="0" />
                            <x-inputs.input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </dd>
                </div>

                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Tipo vehículo que requiere
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <div>
                            <x-select required name="tipo" :items="$tipos_vehiculo" index="0" />
                            <x-inputs.input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </dd>
                </div>

                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Detalle del requerimiento
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <textarea required name="detalle" rows="4"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm resize-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Digite su mensaje aquí..."></textarea>
                    </dd>
                    <input type="hidden" value="{{ $policia['id'] }}" name="id"></input>
                </div>
                <div class="flex justify-end">
                    <x-inputs.primary-button class=" justify-center mt-4 text-xl">
                        {{ __('Solicitar') }}
                    </x-inputs.primary-button>
                </div>
            </form>
        </dl>
    </div>
    @push('scripts')
        @vite('resources/js/datetimeSelects.js')
    @endpush
</x-app-layout>
