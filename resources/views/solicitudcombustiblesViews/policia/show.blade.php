@php
    //dd($datos);
@endphp
<x-app-layout>

    <x-navigation.botonregresar href="{{ route('dashboard') }}" />

    <div class=" px-4 py-1 sm:px-6">
        <h2 class=" text-xl leading-8 font-medium text-gray-900">
            Orden de combustible No {{ $datos->id }}<br />
        </h2>
        <p class=" mt-1 max-w-2xl text-sm text-gray-500">
            Imprima este documento y acuda a la gasolinera afiliada más cercana
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
                    {{ $datos->nombre_completo }}
                </dd>
            </div>

            <div class=" py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class=" text-sm font-medium text-gray-500">
                    Fecha de elaboración
                </dt>
                {{-- campo para llenar fecha --}}
                <dd class=" mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $datos->created_at }}</dd>
            </div>
            <div class=" py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class=" text-sm font-medium text-gray-500">
                    Tipo de combustible solicitado
                </dt>
                {{-- campo para llenar fecha --}}
                <dd class=" mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $datos->tipoCombustible }}</dd>
            </div>
            <div class=" py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class=" text-sm font-medium text-gray-500">
                    Km de soliciud
                </dt>
                {{-- campo para llenar fecha de requerimiento --}}
                <dd class=" mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $datos->solicitudcombustible_km }}</dd>
            </div>
            <div class=" py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class=" text-sm font-medium text-gray-500">
                    Datos vehículo
                </dt>
                <dd class=" mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <span class=" text-xs text-gray-600">Tipo: </span> {{ $datos->marca }} &nbsp /
                    <span class=" text-xs text-gray-600">Modelo: </span>{{ $datos->modelo }} &nbsp /
                    <span class=" text-xs text-gray-600">Marca: </span>{{ $datos->tipo }} &nbsp /
                    <span class=" text-xs text-gray-600">Color: </span>{{ $datos->color }} &nbsp /
                    <span class=" text-xs text-gray-600">Placa: </span>{{ $datos->placa }}
                </dd>
            </div>

        </dl>
    </div>
</x-app-layout>
