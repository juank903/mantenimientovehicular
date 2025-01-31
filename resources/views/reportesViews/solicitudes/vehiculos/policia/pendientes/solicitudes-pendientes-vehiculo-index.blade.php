@php
    //dd($data);
    //gettype($data);
    //$array = json_decode($data, TRUE);
    //print_r($array);
    $id = $data['personal']['user_id'];
    $apellidoPaterno = $data['personal']['primerapellido_personal_policias'];
    $apellidoMaterno = $data['personal']['segundoapellido_personal_policias'];
    $primerNombre = $data['personal']['primernombre_personal_policias'];
    $segundoNombre = $data['personal']['segundonombre_personal_policias'];
    $circuito = $data['personal']['subcircuito'][0]['circuito']['nombre_circuito_dependencias']; // "Oña"
    $subcircuito = $data['personal']['subcircuito'][0]['nombre_subcircuito_dependencias']; // "Zhimad 1"
    $distrito = $data['personal']['subcircuito'][0]['circuito']['distrito']['nombre_distritodependencias']; // "Nabon"
    $provincia =
        $data['personal']['subcircuito'][0]['circuito']['distrito']['provincia']['nombre_provincia_dependencias']; // "Azuay"
    $fechaElaboracionSolicitud = $data['solicitud_pendiente'][0]['created_at'];
    $fechaElaboracionSolicitud = new DateTime($fechaElaboracionSolicitud);
    $fechaElaboracionSolicitud = $fechaElaboracionSolicitud->format('j F Y');
    $estadoSolicitud = $data['solicitud_pendiente'][0]['solicitudvehiculos_estado'];
    $detalleSolicitud = $data['solicitud_pendiente'][0]['solicitudvehiculos_detalle'];
    $fechaRequerimientoVehiculoDesde = $data['solicitud_pendiente'][0]['solicitudvehiculos_fecharequerimientodesde'];
    $fechaRequerimientoVehiculoDesde = new DateTime($fechaRequerimientoVehiculoDesde);
    $fechaRequerimientoVehiculoDesde = $fechaRequerimientoVehiculoDesde->format('j F Y');
    $fechaRequerimientoVehiculoHasta = $data['solicitud_pendiente'][0]['solicitudvehiculos_fecharequerimientohasta'];
    $fechaRequerimientoVehiculoHasta = new DateTime($fechaRequerimientoVehiculoHasta);
    $fechaRequerimientoVehiculoHasta = $fechaRequerimientoVehiculoHasta->format('j F Y');
    $tipoVehiculoSolicitado = $data['solicitud_pendiente'][0]['solicitudvehiculos_tipo'];

@endphp
<x-app-layout>
    <script>
        function openModal() {
            document.getElementById('confirmModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }
    </script>
    <!--Container-->
    <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2 mt-10 z-0 text-sm">
        <div class="bg-white overflow-hidden shadow rounded-lg border">
            @if (Auth::user()->rol() == 'policia')
                <x-navigation.botonregresar href="{{ route('dashboard') }}" />
            @elseif (Auth::user()->rol() == 'administrador')
                <x-navigation.botonregresar href="{{ route('mostrartodasolicitudesvehiculos') }}" />
            @endif


            <div class="px-4 py-1 sm:px-6">
                <h2 class="text-xl leading-8 font-medium text-gray-900">
                    Solicitud Vehicular {{ $estadoSolicitud }}<br />
                </h2>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Esta es la información de la solicitud que usted tiene pendiente hasta el momento, puede
                    anularla si
                    desea.
                </p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Elaborado por
                        </dt>
                        {{-- campo para llenar elaborador por --}}
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $apellidoPaterno }}&nbsp
                            {{ $apellidoMaterno }}&nbsp
                            {{ $primerNombre }}&nbsp
                            {{ $segundoNombre }}
                        </dd>
                        <dt class="text-sm font-medium text-gray-500">
                            Ubicación del solicitante
                        </dt>
                        {{-- campo para llenar fecha --}}
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <span class="text-xs text-gray-600">Subcircuito: </span> {{ $subcircuito }}&nbsp /
                            <span class="text-xs text-gray-600">Circuito: </span> {{ $circuito }}&nbsp /
                            <span class="text-xs text-gray-600">Distrito: </span>{{ $distrito }}&nbsp /
                            <span class="text-xs text-gray-600">Provincia: </span>{{ $provincia }}
                        </dd>
                        <dt class="text-sm font-medium text-gray-500">
                            Fecha elaboración solicitud
                        </dt>
                        {{-- campo para llenar fecha --}}
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $fechaElaboracionSolicitud }}</dd>
                    </div>
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Detalle de la solicitud
                        </dt>
                        {{-- campo para llenar detalle solicitud --}}
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $detalleSolicitud }}</dd>
                    </div>
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Fecha requerimiento del vehículo - Desde
                        </dt>
                        {{-- campo para llenar fecha de requerimiento --}}
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $fechaRequerimientoVehiculoDesde }}</dd>
                    </div>
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Fecha requerimiento del vehículo - Hasta
                        </dt>
                        {{-- campo para llenar fecha de requerimiento --}}
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $fechaRequerimientoVehiculoHasta }}</dd>
                    </div>
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Tipo de vehículo solicitado
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $tipoVehiculoSolicitado }}</dd>
                    </div>
                </dl>

                @if (Auth::user()->rol() == 'policia')
                    <button onclick="openModal()"
                        class="w-full items-center justify-center px-6 py-3 bg-red-600 text-white text-lg font-semibold shadow-lg transform hover:scale-105 transition-transform duration-200">
                        Anular Solicitud
                    </button>
                @endif

            </div>
        </div>

    </div>

    <!-- Modal de Confirmación -->
    <div id="confirmModal" class="fixed inset-0 flex items-start justify-center bg-gray-900 bg-opacity-50 hidden pt-10">
        <div class="bg-white p-6 rounded-lg shadow-xl w-1/3 flex flex-col items-center">
            <h3 class="text-lg font-semibold text-gray-800">Confirmar Anulación</h3>
            <p class="text-sm text-gray-600 mt-2 text-center">Seleccione el motivo de la anulación:</p>

            <form method="POST" id="anularForm" action="{{ route('anularsolicitudvehiculopolicia-pendiente') }}"
                class="w-full">
                {{-- @method('PUT') --}}
                @csrf
                <div class="mt-4 w-full">
                    <label class="flex items-center">
                        <input type="checkbox" name="motivo" value="errores" class="mr-2"> Errores en la solicitud
                    </label>
                    <label class="flex items-center mt-2">
                        <input type="checkbox" name="motivo" value="no_requiere" class="mr-2"> Ya no requiere el
                        vehículo
                    </label>

                </div>
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="flex justify-center mt-4 w-full">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-300 rounded-md mr-2">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Confirmar</button>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
