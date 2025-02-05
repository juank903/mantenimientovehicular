<x-app-layout>
    @if (session('mensaje') || session('error'))
        @include('components.mensajemodalexito')
    @endif
    <div
        class="flex flex-row space-x-4 overflow-x-auto md:w-4/5 xl:w-3/5 mx-auto px-2 z-0 text-sm">
        @if (Auth::user()->rol() == 'policia')
            <!-- Columna 1 -->
            <div class="flex flex-col items-center w-1/4 flex-wrap gap-4">
                <x-panelesinfo.cardinfo estado="Pendiente" id="solicitudvehiculo_pendiente" :api="url('/api/personal/policia/' . auth()->id() . '/totalsolicitudesvehiculos/pendientes')" :
                    :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Pendiente']" />
                <x-panelesinfo.cardinfo estado="Anulada" id="solicitudvehiculo_anulada" :api="url('/api/personal/policia/' . auth()->id() . '/totalsolicitudesvehiculos/anuladas')" :
                    :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Anuladas']" />
                <x-panelesinfo.cardinfo estado="Aprobada" id="solicitudvehiculo_aprobada" :api="url('/api/personal/policia/' . auth()->id() . '/totalsolicitudesvehiculos/aprobadas')" :
                    :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Aprobadas']" />
            </div>
            <!-- Columna 2 -->
            {{-- <div class="flex flex-col items-center w-1/4 flex-wrap gap-4">

                </div> --}}
            <!-- Columna 3 -->
            {{-- <div class="flex flex-col items-center w-1/4 flex-wrap gap-4">
                <ul>
                    @foreach (session('personal') as $key => $dato)
                        <li> {{ $key }} {{ $dato }} </li>
                    @endforeach
                </ul>
            </div> --}}
        @endif
        @if (Auth::user()->rol() == 'administrador' || Auth::user()->rol() == 'gerencia')
            <!-- Columna 1 -->
            <div class="flex flex-col items-center w-1/4 flex-wrap gap-4">
                <x-panelesinfo.cardinfo estado="Pendiente" id="solicitudesvehiculos_pendientes" :api="url('/api/totalsolicitudesvehiculos/pendientes')" :
                    :items="['titulo' => 'Total solicitudes Vehiculo', 'mensaje' => 'para aprobar']" />
                <x-panelesinfo.cardinfo estado="Anulada" id="solicitudesvehiculos_anuladas" :api="url('/api/totalsolicitudesvehiculos/anuladas')" :
                    :items="['titulo' => 'Total solicitudes Vehiculo', 'mensaje' => 'anuladas']" />
                <x-panelesinfo.cardinfo estado="Aprobada" id="solicitudesvehiculos_aprobadas" :api="url('/api/totalsolicitudesvehiculos/aprobadas')" :
                    :items="['titulo' => 'Total solicitudes Vehiculo', 'mensaje' => 'aprobadas']" />
            </div>

            <!-- Columna 2 -->
            {{-- <div class="flex flex-col items-center w-1/4 flex-wrap gap-4">

            </div> --}}
            <!-- Columna 3 -->
            {{-- <div class="flex flex-col items-center w-1/4 flex-wrap gap-4">
                <ul>
                    @foreach (session('personal') as $key => $dato)
                        <li> {{ $key }} {{ $dato }} </li>
                    @endforeach
                </ul>
            </div> --}}
        @endif
    </div>
</x-app-layout>
