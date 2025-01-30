@php
    //dd($data);
    //gettype($data);
    //$array = json_decode($data, TRUE);
    //print_r($array);

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
    $fechaElaboracionSolicitud = new DateTime($fechaElaboracionSolicitud );
    $fechaElaboracionSolicitud = $fechaElaboracionSolicitud->format('j F Y');
    $estadoSolicitud = $data['solicitud_pendiente'][0]['solicitudvehiculos_estado'];
    $detalleSolicitud = $data['solicitud_pendiente'][0]['solicitudvehiculos_detalle'];
    $fechaRequerimientoVehiculo = $data['solicitud_pendiente'][0]['solicitudvehiculos_fecharequerimiento'];
    $fechaRequerimientoVehiculo = new DateTime($fechaRequerimientoVehiculo );
    $fechaRequerimientoVehiculo = $fechaRequerimientoVehiculo->format('j F Y');

    $tipoVehiculoSolicitado = $data['solicitud_pendiente'][0]['solicitudvehiculos_tipo'];


@endphp

<x-app-layout>
    <!--Container-->
    <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2 mt-10 z-0 text-sm">
        <div class="bg-white overflow-hidden shadow rounded-lg border">
            <x-navigation.botonregresar href="{{ route('dashboard') }}" />
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
                            Fecha requerimiento del vehículo
                        </dt>
                        {{-- campo para llenar fecha de requerimiento --}}
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $fechaRequerimientoVehiculo }}</dd>
                    </div>
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Tipo de vehículo solicitado
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $tipoVehiculoSolicitado }}</dd>
                    </div>
                </dl>
                <form method="POST"
                    class="relative flex items-center justify-center px-6 py-3 bg-red-600 text-white text-lg font-semibold shadow-lg transform hover:scale-105 transition-transform duration-200"
                    action="{{ route('anularsolicitudvehiculopolicia-pendiente', auth()->id()) }}">
                    @method('PUT')
                    @csrf
                    <button type="submit">
                        <span class="relative z-10">Anular Solicitud</span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
