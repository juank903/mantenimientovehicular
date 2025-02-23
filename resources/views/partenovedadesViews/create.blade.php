<x-app-layout>

    <x-navigation.botonregresar href="{{ route('dashboard') }}" />

    <div class=" px-4 py-1 sm:px-6">
        <h2 class=" text-xl leading-8 font-medium text-gray-900">
            Vehiculo en Campo solicitud No {{ $asignacion_solicitudvehiculo['id'] }}<br />
        </h2>
        <p class=" mt-1 max-w-2xl text-sm text-gray-500">
            Imprima este documento y acuda al parquedero para entregar el vehículo asignado
        </p>
    </div>
    <div class=" border-t border-gray-200 px-4 py-5 sm:p-0">
        <dl class=" sm:divide-y sm:divide-gray-200">
            <div class=" py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class=" text-sm font-medium text-gray-500">
                    Solicitante
                </dt>
                {{-- campo para llenar elaborador por --}}
                <dd class=" mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $solicitante['rango'] }}&nbsp;{{ $solicitante['nombre_completo'] }}
                </dd>
            </div>
            <div class=" py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class=" text-sm font-medium text-gray-500">
                    Ubicación del solicitante
                </dt>

                <dd class=" mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <span class=" text-xs text-gray-600">Subcircuito: </span>
                    {{ $solicitante['subcircuitos'][0]['nombre'] }}&nbsp /
                    <span class=" text-xs text-gray-600">Circuito: </span>
                    {{ $solicitante['subcircuitos'][0]['circuito']['nombre'] }}&nbsp /
                    <span class=" text-xs text-gray-600">Distrito:
                    </span>{{ $solicitante['subcircuitos'][0]['circuito']['distrito']['nombre'] }}&nbsp /
                    <span class=" text-xs text-gray-600">Provincia:
                    </span>{{ $solicitante['subcircuitos'][0]['circuito']['distrito']['provincia']['nombre'] }}
                </dd>
            </div>
            <div class=" py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class=" text-sm font-medium text-gray-500">
                    Fecha elaboración solicitud
                </dt>
                {{-- campo para llenar fecha --}}
                <dd class=" mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $asignacion_solicitudvehiculo['fecha_elaboracion'] }}</dd>
            </div>
            <div class=" py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class=" text-sm font-medium text-gray-500">
                    Fecha asignacion vehículo
                </dt>
                {{-- campo para llenar fecha --}}
                <dd class=" mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $asignacion_solicitudvehiculo['fecha_aprobacion'] }}</dd>
            </div>
            <div class=" py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class=" text-sm font-medium text-gray-500">
                    Fecha requerimiento del vehículo - Desde
                </dt>
                {{-- campo para llenar fecha de requerimiento --}}
                <dd class=" mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $asignacion_solicitudvehiculo['fecharequerimientodesde'] }}</dd>
            </div>
            <div class=" py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class=" text-sm font-medium text-gray-500">
                    Fecha requerimiento del vehículo - Hasta
                </dt>
                {{-- campo para llenar fecha de requerimiento --}}
                <dd class=" mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $asignacion_solicitudvehiculo['fecharequerimientohasta'] }}</dd>
            </div>
            <div class=" py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class=" text-sm font-medium text-gray-500">
                    Vehiculo asignado
                </dt>
                <dd class=" mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <span class=" text-xs text-gray-600">Tipo: </span> {{ $vehiculo['tipo'] }} &nbsp /
                    <span class=" text-xs text-gray-600">Modelo: </span>{{ $vehiculo['modelo'] }} &nbsp /
                    <span class=" text-xs text-gray-600">Marca: </span>{{ $vehiculo['marca'] }} &nbsp /
                    <span class=" text-xs text-gray-600">Color: </span>{{ $vehiculo['color'] }} &nbsp /
                    <span class=" text-xs text-gray-600">Placa: </span>{{ $vehiculo['placa'] }}
                </dd>
            </div>
            <form method="POST" action="{{ route('partenovedades.store') }}">
                @csrf
                <input type="hidden" name="personalpolicia_id" value="{{ $solicitante['id_solicitante'] }}"></input>
                <input type="hidden" name="vehiculo_id" value="{{ $vehiculo['id_vehiculo'] }}"></input>
                <input type="hidden" name="asignacionvehiculo_id" value="{{ $asignacion['id'] }}"></input>

                <div class=" py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class=" text-sm font-medium text-gray-500">
                        Tipo Novedad
                    </dt>
                    <dd class=" mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <x-select id="partenovedades_tipo" name="partenovedades_tipo" :items="$novedadArray"
                            :indice="0" required />
                    </dd>
                </div>
                <div class=" py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class=" text-sm font-medium text-gray-500">
                        Estado Vehículo
                    </dt>
                    <dd class=" mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <span class=" text-xs text-gray-600">Kilometraje actual: </span>
                        <input type="text" name="kilometraje_actual" value="{{ $vehiculo['kmActual'] }}"
                            min="{{ $vehiculo['kmActual'] }}" max="900000"></br><br>
                        <span class=" text-xs text-gray-600">Combustible actual: </span>
                        <x-select id="partenovedades_combustible" name="partenovedades_combustible" :items="$combustibleArray"
                            required />
                    </dd>
                </div>
                <div class=" py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class=" text-sm font-medium text-gray-500">
                        Reporte Novedades
                    </dt>
                    <dd class=" mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <textarea id="partenovedades_detalle" name="partenovedades_detalle" class="w-full"></textarea>
                    </dd>
                </div>
                <div class="flex gap-10 justify-end">
                    <button type="submit" id="btnEntregarVehiculo"
                        class="rounded-md items-center justify-center text-md px-3 py-2 bg-green-600 text-white shadow-lg transform hover:scale-105 transition-transform duration-200">
                        Enviar Parte
                    </button>
                </div>
            </form>
        </dl>
    </div>
</x-app-layout>
