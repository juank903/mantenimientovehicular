@php
    //dd($data);
    //gettype($data);
    //$array = json_decode($data, TRUE);
    //print_r($array);
@endphp

<x-app-layout>
    <!--Container-->
    <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2 mt-10 z-0 text-sm">
        <div class="bg-white overflow-hidden shadow rounded-lg border">
            <x-navigation.botonregresar href="{{ route('dashboard') }}" />
            <div class="px-4 py-1 sm:px-6">
                <h2 class="text-2xl leading-8 font-medium text-gray-900">
                    Solicitud Pendiente<br />
                </h2>
                <h3 class="text-4xl leading-8 font-medium text-gray-900">
                    {{ $data[0]['personal'][0]['primerapellido_personal_policias'] }}&nbsp
                    {{ $data[0]['personal'][0]['segundoapellido_personal_policias'] }}&nbsp
                    {{ $data[0]['personal'][0]['primernombre_personal_policias'] }}&nbsp
                    {{ $data[0]['personal'][0]['segundonombre_personal_policias'] }}
                </h3><br />
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Esta es la información de la solicitud que usted tiene pendiente hasta el momento, puede anularla si
                    desea.
                </p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Fecha de creación
                        </dt>
                        {{-- campo para llenar fecha --}}
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $data[0]['created_at'] }}</dd>
                    </div>
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Detalle de la solicitud
                        </dt>
                        {{-- campo para llenar detalle solicitud --}}
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $data[0]['solicitudvehiculos_detalle'] }}</dd>
                    </div>
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Fecha en que requiere el vehículo
                        </dt>
                        {{-- campo para llenar fecha de requerimiento --}}
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $data[0]['solicitudvehiculos_fecharequerimiento'] }}</dd>
                    </div>
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Tipo de vehículo solicitado
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $data[0]['solicitudvehiculos_tipo'] }}</dd>
                    </div>
                </dl>
                <form method="POST" class="relative flex items-center justify-center px-6 py-3 bg-red-600 text-white text-lg font-semibold shadow-lg transform hover:scale-105 transition-transform duration-200" action="{{ url("/api/solicitud-vehiculo/anular/" . auth()->id() ) }}">
                    @method('PUT')
                    @csrf
                    <button type="submit">
                    <!-- Arka Plan Puls Etkisi -->
                    <span class="relative z-10">Anular Solicitud</span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
