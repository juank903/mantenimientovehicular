<x-app-layout>
    @if (session('mensaje') || session('error'))
        @include('components.mensajemodalexito')
    @endif
    <div
        class="flex flex-row space-x-4 overflow-x-auto max-h-[700px] w-full md:w-4/5 xl:w-3/5 mx-auto px-2 mt-10 z-0 text-sm">
        <!-- Columna 1 -->
        <div class="flex flex-col items-center w-1/4 flex-wrap gap-4">
            <x-panelesinfo.cardinfo estado="Pendiente" id="solicitudvehiculo_pendiente" :api="url('/api/personal/' . auth()->id() . '/solicitudes/pendientes')" :
                :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Pendiente']" />
            <x-panelesinfo.cardinfo estado="Anulada" id="solicitudvehiculo_anulada" :api="url('/api/personal/' . auth()->id() . '/solicitudes/anuladas')" :
                :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Anuladas']" />
            <x-panelesinfo.cardinfo estado="Aprobada" id="solicitudvehiculo_aprobada" :api="url('/api/personal/' . auth()->id() . '/solicitudes/aprobadas')" :
                :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Aprobadas']" />
        </div>
        <!-- Columna 2 -->
        <div class="flex flex-col items-center w-1/4 flex-wrap gap-4">
            <x-panelesinfo.cardinfo estado="Pendiente" id="solicitudmantenimiento_pendiente" :api="url('/api/personal/' . auth()->id() . '/solicitudes/pendientes')" :
                :items="['titulo' => 'Solicitud Mantenimiento', 'mensaje' => 'Pendiente']" />
            <x-panelesinfo.cardinfo estado="Anulada" id="solicitudmantenimiento_anulada" :api="url('/api/personal/' . auth()->id() . '/solicitudes/anuladas')" :
                :items="['titulo' => 'Solicitud Mantenimiento', 'mensaje' => 'Anuladas']" />
            <x-panelesinfo.cardinfo estado="Aprobada" id="solicitudmantenimiento_aprobada" :api="url('/api/personal/' . auth()->id() . '/solicitudes/aprobadas')" :
                :items="['titulo' => 'Solicitud Mantenimiento', 'mensaje' => 'Aprobadas']" />
        </div>
        <!-- Columna 3 -->
        <div class="flex flex-col items-center w-1/4 flex-wrap gap-4">
            <ul>
                @foreach (session('personal') as $key => $dato)
                    <li> {{ $key }} {{ $dato }} </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
