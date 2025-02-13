<x-app-layout>
    <div id="imprimible">
        <x-navigation.botonregresar href="{{ route('dashboard') }}" />

        <div class="px-4 py-1 sm:px-6">
            <h2 class="text-xl leading-8 font-medium text-gray-900">
                Aprobación de solicitud No {{ $solicitud['id'] }}<br />
            </h2>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Imprima este documento y acuda al parquedero para entregar el vehículo asignado
            </p>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200">
                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Solicitante
                    </dt>
                    {{-- campo para llenar elaborador por --}}
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $policia['apellido_paterno'] }}&nbsp
                        {{ $policia['apellido_materno'] }}&nbsp
                        {{ $policia['primer_nombre'] }}&nbsp
                        {{ $policia['segundo_nombre'] }}
                    </dd>
                    <dt class="text-sm font-medium text-gray-500">
                        Ubicación del solicitante
                    </dt>
                    {{-- campo para llenar fecha --}}
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <span class="text-xs text-gray-600">Subcircuito: </span> {{ $policia['subcircuito'] }}&nbsp /
                        <span class="text-xs text-gray-600">Circuito: </span> {{ $policia['circuito'] }}&nbsp /
                        <span class="text-xs text-gray-600">Distrito: </span>{{ $policia['distrito'] }}&nbsp /
                        <span class="text-xs text-gray-600">Provincia: </span>{{ $policia['provincia'] }}
                    </dd>
                    <dt class="text-sm font-medium text-gray-500">
                        Fecha elaboración solicitud
                    </dt>
                    {{-- campo para llenar fecha --}}
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $solicitud['fecha_solicitado'] }}</dd>
                </div>
                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Detalle de la solicitud
                    </dt>
                    {{-- campo para llenar detalle solicitud --}}
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $solicitud['detalle'] }}</dd>
                </div>
                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Fecha requerimiento del vehículo - Desde
                    </dt>
                    {{-- campo para llenar fecha de requerimiento --}}
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $solicitud['fecha_desde'] }}</dd>
                </div>
                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Fecha requerimiento del vehículo - Hasta
                    </dt>
                    {{-- campo para llenar fecha de requerimiento --}}
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $solicitud['fecha_hasta'] }}</dd>
                </div>
                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Tipo de vehículo solicitado
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $solicitud['tipo_vehiculo'] }}</dd>
                </div>
            </dl>



        </div>
    </div>
    <div class="flex justify-end">
        <button onclick="imprimirCard()"
            class="items-center justify-center text-md px-3 py-2 bg-blue-600 text-white shadow-lg transform hover:scale-105 transition-transform duration-200">
            Imprimir
        </button>
    </div>
    @push('scripts')
        <script>
            function imprimirCard() {
                printJS({
                    printable: 'imprimible',
                    type: 'html',
                    css: 'print.css'
                });
            }
        </script>
    @endpush
</x-app-layout>
