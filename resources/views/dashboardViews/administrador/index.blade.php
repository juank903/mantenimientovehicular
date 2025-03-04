<x-app-layout>
    @if (session('mensaje') || session('error'))
    <x-mensajemodalexito/>
    @endif
    Estoy en la vista administrador
    <div class="flex flex-row space-x-4 overflow-x-auto md:w-4/5 xl:w-3/5 mx-auto px-2 z-0 text-sm">
        <!-- Columna 1 -->
        <div class="flex flex-col items-center flex-wrap gap-4">
            <x-panelesinfo.cardinfo-animado estado="Pendiente" id="solicitudesvehiculos_pendientes" :api="url('/api/totalsolicitudesvehiculos/pendientes')" :
                :items="['titulo' => 'Total solicitudes Vehiculo', 'mensaje' => 'para aprobar']" />
            <x-panelesinfo.cardinfo-animado estado="Anulada" id="solicitudesvehiculos_anuladas" :api="url('/api/totalsolicitudesvehiculos/anuladas')" :
                :items="['titulo' => 'Total solicitudes Vehiculo', 'mensaje' => 'anuladas']" />
            <x-panelesinfo.cardinfo-animado estado="Aprobada" id="solicitudesvehiculos_aprobadas" :api="url('/api/totalsolicitudesvehiculos/aprobadas')" :
                :items="['titulo' => 'Total solicitudes Vehiculo', 'mensaje' => 'aprobadas']" />
            <x-panelesinfo.cardinfo-animado estado="Procesando" id="solicitudesvehiculos_procesando" :api="url('/api/totalsolicitudesvehiculos/procesando')" :
                :items="['titulo' => 'Total solicitudes Vehiculo', 'mensaje' => 'procesando']" />
            <x-panelesinfo.cardinfo-animado estado="Completa" id="solicitudesvehiculos_completas" :api="url('/api/totalsolicitudesvehiculos/completas')" :
                :items="['titulo' => 'Total solicitudes Vehiculo', 'mensaje' => 'completas']" />
        </div>
    </div>
</x-app-layout>
