<x-app-layout>

    <x-navigation.botonregresar href="{{ route('dashboard') }}" />

    <div class="imprimible px-4 py-1 sm:px-6">
        <h2 class="imprimible text-xl leading-8 font-medium text-gray-900">
            Entrega Recepción de vehículo - solicitud No {{ $asignacion_solicitudvehiculo['id'] }}<br />
        </h2>
        <p class="imprimible mt-1 max-w-2xl text-sm text-gray-500">
            Imprima este documento y acuda al parquedero para entregar el vehículo asignado
        </p>
    </div>
    <div class="imprimible border-t border-gray-200 px-4 py-5 sm:p-0">
        <dl class="imprimible sm:divide-y sm:divide-gray-200">
            <div class="imprimible py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="imprimible text-sm font-medium text-gray-500">
                    Solicitante
                </dt>
                <dd class="imprimible mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $solicitante['rango'] }}&nbsp;{{ $solicitante['nombre_completo'] }}
                </dd>
            </div>
            <div class="imprimible py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="imprimible text-sm font-medium text-gray-500">
                    Ubicación del solicitante
                </dt>

                <dd class="imprimible mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <span class="imprimible text-xs text-gray-600">Subcircuito: </span>
                    {{ $solicitante['subcircuitos'][0]['nombre'] }}&nbsp /
                    <span class="imprimible text-xs text-gray-600">Circuito: </span>
                    {{ $solicitante['subcircuitos'][0]['circuito']['nombre'] }}&nbsp /
                    <span class="imprimible text-xs text-gray-600">Distrito:
                    </span>{{ $solicitante['subcircuitos'][0]['circuito']['distrito']['nombre'] }}&nbsp /
                    <span class="imprimible text-xs text-gray-600">Provincia:
                    </span>{{ $solicitante['subcircuitos'][0]['circuito']['distrito']['provincia']['nombre'] }}
                </dd>
            </div>
            <div class="imprimible py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="imprimible text-sm font-medium text-gray-500">
                    Fecha elaboración solicitud
                </dt>
                {{-- campo para llenar fecha --}}
                <dd class="imprimible mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $asignacion_solicitudvehiculo['fecha_elaboracion'] }}</dd>
            </div>
            <div class="imprimible py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="imprimible text-sm font-medium text-gray-500">
                    Fecha aprobacion
                </dt>
                {{-- campo para llenar fecha --}}
                <dd class="imprimible mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $asignacion_solicitudvehiculo['fecha_aprobacion'] }}</dd>
            </div>
            <div class="imprimible py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="imprimible text-sm font-medium text-gray-500">
                    Fecha requerimiento del vehículo - Desde
                </dt>
                {{-- campo para llenar fecha de requerimiento --}}
                <dd class="imprimible mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $asignacion_solicitudvehiculo['fecharequerimientodesde'] }}</dd>
            </div>
            <div class="imprimible py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="imprimible text-sm font-medium text-gray-500">
                    Fecha requerimiento del vehículo - Hasta
                </dt>
                {{-- campo para llenar fecha de requerimiento --}}
                <dd class="imprimible mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $asignacion_solicitudvehiculo['fecharequerimientohasta'] }}</dd>
            </div>
            <div class="imprimible py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="imprimible text-sm font-medium text-gray-500">
                    Detalle de la solicitud
                </dt>
                {{-- campo para llenar detalle solicitud --}}
                <dd class="imprimible mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $asignacion_solicitudvehiculo['detalle'] }}</dd>
            </div>
            <div class="imprimible py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="imprimible text-sm font-medium text-gray-500">
                    Vehiculo asignado
                </dt>
                <dd class="imprimible mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <div class="hidden" id="asignacionId"> {{ $asignacion['id'] }} </div>
                    <span class="imprimible text-xs text-gray-600">Tipo: </span> {{ $vehiculo['tipo'] }} &nbsp /
                    <span class="imprimible text-xs text-gray-600">Modelo: </span>{{ $vehiculo['modelo'] }} &nbsp /
                    <span class="imprimible text-xs text-gray-600">Marca: </span>{{ $vehiculo['marca'] }} &nbsp /
                    <span class="imprimible text-xs text-gray-600">Color: </span>{{ $vehiculo['color'] }} &nbsp /
                    <span class="imprimible text-xs text-gray-600">Placa: </span>{{ $vehiculo['placa'] }}
                </dd>
            </div>
            <div class="imprimible py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="imprimible text-sm font-medium text-gray-500">
                    Ubicación del Vehículo
                </dt>
                <dd class="imprimible mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <span class="imprimible text-xs text-gray-600">Nombre: </span>
                    {{ $vehiculo['parqueadero'][0]['nombre'] }} &nbsp /
                    <span class="imprimible text-xs text-gray-600">Espacio: </span>
                    {{ $vehiculo['espacio'][0]['nombre'] }}
                    &nbsp - &nbsp {{ $vehiculo['espacio'][0]['observacion'] }} /
                    <span class="imprimible text-xs text-gray-600">Dirección:
                    </span>{{ $vehiculo['parqueadero'][0]['direccion'] }} &nbsp /

                    <span class="imprimible text-xs text-gray-600">Responsable:
                    </span>{{ $vehiculo['parqueadero'][0]['responsable'] }}
                </dd>
            </div>
            <div class="imprimible py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="imprimible text-sm font-medium text-gray-500">
                    Estado Vehículo
                </dt>
                <dd class="imprimible mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <span class="imprimible text-xs text-gray-600">Kilometraje actual: </span>
                    {{ $vehiculo['kmActual'] }}
                    &nbsp /
                    <span class="imprimible text-xs text-gray-600">Combustible actual: </span>
                    {{ $vehiculo['combustibleActual'] }} &nbsp /
            </div>
        </dl>

    </div>

    <div class="flex gap-10 justify-end no-print">
        <button id="btnEntregarVehiculo"
            class="rounded-md items-center justify-center text-md px-3 py-2 bg-green-600 text-white shadow-lg transform hover:scale-105 transition-transform duration-200">
            Entregar vehículo
        </button>
        <button onclick="window.print()"
            class="rounded-md items-center justify-center text-md px-3 py-2 bg-blue-600 text-white shadow-lg transform hover:scale-105 transition-transform duration-200">
            Imprimir
        </button>
    </div>

    {{-- <div id="modalConfirmacion" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                Confirmar entrega de vehículo
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    ¿Está seguro de que desea entregar este vehículo?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button id="btnConfirmar" type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Confirmar
                    </button>
                    <button id="btnCancelar" type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div> --}}

    @push('scripts')
        @vite('resources/js/showEntregarVehiculoAuxiliar.js')
    @endpush
    {{-- <script>
        const btnEntregarVehiculo = document.getElementById('btnEntregarVehiculo');
        const modalConfirmacion = document.getElementById('modalConfirmacion');
        const btnConfirmar = document.getElementById('btnConfirmar');
        const btnCancelar = document.getElementById('btnCancelar');

        btnEntregarVehiculo.addEventListener('click', () => {
            modalConfirmacion.classList.remove('hidden');
        });

        btnCancelar.addEventListener('click', () => {
            modalConfirmacion.classList.add('hidden');
        });

        btnConfirmar.addEventListener('click', () => {
            modalConfirmacion.classList.add('hidden');

            const asignacionId = "{{ $asignacion['id'] }}"; // Make sure $asignacion['id'] is available
            console.log(asignacionId);

            fetch(`/api/entregarvehiculo/policia?asignacion_id=${asignacionId}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: data.message,
                            confirmButtonText: 'OK',
                        }).then(() => {
                            window.location.href =
                                "{{ route('dashboard') }}"; // Redirect after success
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            confirmButtonText: 'OK',
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al entregar el vehículo.',
                        confirmButtonText: 'OK',
                    });
                });
        });
    </script> --}}

</x-app-layout>
