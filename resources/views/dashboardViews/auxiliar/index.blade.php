<x-app-layout>
    @if (session('mensaje') || session('error'))
        @include('components.mensajemodalexito')
    @endif
    Estoy en la vista auxiliar
    <div class="flex flex-row space-x-4 overflow-x-auto md:w-4/5 xl:w-3/5 mx-auto px-2 z-0 text-sm">
        <!-- Columna 1 -->
        <div class="flex flex-col items-center w-1/4 flex-wrap gap-4">
            <x-panelesinfo.cardinfo estado="Pendiente" id="solicitudvehiculo_pendiente" :api="url('/api/personal/policia/' . auth()->id() . '/totalsolicitudesvehiculos/pendientes')" :
                :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Pendiente']" />
            <x-panelesinfo.cardinfo estado="Anulada" id="solicitudvehiculo_anulada" :api="url('/api/personal/policia/' . auth()->id() . '/totalsolicitudesvehiculos/anuladas')" :
                :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Anuladas']" />
            <x-panelesinfo.cardinfo estado="Aprobada" id="solicitudvehiculo_aprobada" :api="url('/api/personal/policia/' . auth()->id() . '/totalsolicitudesvehiculos/aprobadas')" :
                :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Aprobadas']" />
        </div>
    </div>
</x-app-layout>
