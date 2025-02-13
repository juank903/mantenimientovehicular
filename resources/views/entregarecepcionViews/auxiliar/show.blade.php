<x-app-layout>

    <x-navigation.botonregresar href="{{ route('dashboard') }}" />

    <div class="px-4 py-1 sm:px-6">
        <h2 class="text-xl leading-8 font-medium text-gray-900">
            Entrega Recepción de solicitud vehicular No  {{ $solicitud['id'] }}<br />
        </h2>
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

        <div class="flex justify-end">
            <button onclick="openModal()"
                class="items-center justify-center text-md px-3 py-2 bg-red-600 text-white shadow-lg transform hover:scale-105 transition-transform duration-200">
                Entregar vehículo
            </button>
        </div>

    </div>

    <!-- Modal de Confirmación -->
    <div id="confirmModal" class="fixed inset-0 hidden items-start justify-center bg-gray-900 bg-opacity-50 pt-10">
        <div class="bg-white p-6 rounded-lg shadow-xl w-1/3 flex flex-col items-center">
            <h3 class="text-lg font-semibold text-gray-800">Confirmar Anulación</h3>
            <p class="text-sm text-gray-600 mt-2 text-center">Seleccione el motivo de la anulación:</p>

            <form method="POST" id="anularForm" action="{{ route('anularsolicitudvehiculopolicia-pendiente') }}"
                class="w-full">
                @csrf
                <div class="mt-4 w-full">
                    <label class="flex items-center">
                        <input type="radio" name="motivo" value="errores" class="mr-2"> Errores en la solicitud
                    </label>
                    <label class="flex items-center mt-2">
                        <input type="radio" name="motivo" value="no_requiere" class="mr-2"> Ya no requiere el
                        vehículo
                    </label>
                </div>
                <input type="hidden" name="id" value="{{ $policia['id'] }}">
                <div class="flex justify-center mt-4 w-full">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-300 rounded-md mr-2">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Confirmar</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function openModal() {
                console.log('open');
                let modal = document.getElementById("confirmModal");
                modal.classList.remove("hidden");
                modal.classList.add("flex");
            }

            function closeModal() {
                console.log('close');
                let modal = document.getElementById("confirmModal");
                modal.classList.remove("flex");
                modal.classList.add("hidden");
            }
        </script>
    @endpush
</x-app-layout>
<x-app-layout>

    <x-navigation.botonregresar href="{{ route('dashboard') }}" />

    <div class="px-4 py-1 sm:px-6">
        <h2 class="text-xl leading-8 font-medium text-gray-900">
            Aprobación de solicitud No  {{ $solicitud['id'] }}<br />
        </h2>
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

        <div class="flex justify-end">
            <button onclick="openModal()"
                class="items-center justify-center text-md px-3 py-2 bg-red-600 text-white shadow-lg transform hover:scale-105 transition-transform duration-200">
                Entregar vehículo
            </button>
        </div>

    </div>

    <!-- Modal de Confirmación -->
    <div id="confirmModal" class="fixed inset-0 hidden items-start justify-center bg-gray-900 bg-opacity-50 pt-10">
        <div class="bg-white p-6 rounded-lg shadow-xl w-1/3 flex flex-col items-center">
            <h3 class="text-lg font-semibold text-gray-800">Confirmar Anulación</h3>
            <p class="text-sm text-gray-600 mt-2 text-center">Seleccione el motivo de la anulación:</p>

            <form method="POST" id="anularForm" action="{{ route('anularsolicitudvehiculopolicia-pendiente') }}"
                class="w-full">
                @csrf
                <div class="mt-4 w-full">
                    <label class="flex items-center">
                        <input type="radio" name="motivo" value="errores" class="mr-2"> Errores en la solicitud
                    </label>
                    <label class="flex items-center mt-2">
                        <input type="radio" name="motivo" value="no_requiere" class="mr-2"> Ya no requiere el
                        vehículo
                    </label>
                </div>
                <input type="hidden" name="id" value="{{ $policia['id'] }}">
                <div class="flex justify-center mt-4 w-full">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-300 rounded-md mr-2">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Confirmar</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function openModal() {
                console.log('open');
                let modal = document.getElementById("confirmModal");
                modal.classList.remove("hidden");
                modal.classList.add("flex");
            }

            function closeModal() {
                console.log('close');
                let modal = document.getElementById("confirmModal");
                modal.classList.remove("flex");
                modal.classList.add("hidden");
            }
        </script>
    @endpush
</x-app-layout>
