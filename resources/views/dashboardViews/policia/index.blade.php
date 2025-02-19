<x-app-layout>
    @if (session('mensaje') || session('error'))
        <x-mensajemodalexito />
    @endif
    Estoy en la vista policia
    <div class="flex flex-row space-x-4 overflow-x-auto md:w-4/5 xl:w-3/5 mx-auto px-2 z-0 text-sm">
        <!-- Columna 1 -->
        <div class="flex flex-col items-center flex-wrap gap-4">
            <x-panelesinfo.cardinfo-animado estado="Pendiente" id="solicitudvehiculo_pendiente" :api="url('/api/personal/policia/' . auth()->id() . '/totalsolicitudesvehiculos/pendientes')"
                :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Pendiente']" />
            <x-panelesinfo.cardinfo-animado estado="Anulada" id="solicitudvehiculo_anulada" :api="url('/api/personal/policia/' . auth()->id() . '/totalsolicitudesvehiculos/anuladas')"
                :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Anuladas']" />
            <x-panelesinfo.cardinfo-animado estado="Aprobada" id="solicitudvehiculo_aprobada" :api="url('/api/personal/policia/' . auth()->id() . '/totalsolicitudesvehiculos/aprobadas')"
                :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Aprobadas']" />
            <x-panelesinfo.cardinfo-animado estado="Procesando" id="solicitudvehiculo_procesando" :api="url('/api/personal/policia/' . auth()->id() . '/totalsolicitudesvehiculos/procesando')"
                :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Procesando']" />
            <x-panelesinfo.cardinfo-animado estado="Completa" id="solicitudvehiculo_completa" :api="url('/api/personal/policia/' . auth()->id() . '/totalsolicitudesvehiculos/completas')"
                :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Completas']" />
        </div>
    </div>
</x-app-layout>
