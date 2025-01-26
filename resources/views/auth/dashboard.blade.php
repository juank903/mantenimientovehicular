<x-app-layout>
    @if (session('mensaje') || session('error'))
        @include('components.mensajemodalexito')
    @endif
    <div class="flex space-x-4 container w-full md:w-4/5 xl:w-3/5  mx-auto px-2 mt-10 z-0 text-sm">
        <x-panelesinfo.cardinfo
        estado="Pendiente"
        id="solicitudvehiculoa_pendiente"
        :api="url('/api/personal/' . auth()->id() . '/solicitudes')" :
        :items="['titulo'=>'Solicitud Vehiculo', 'mensaje'=>'Pendiente']"
        />
        <x-panelesinfo.cardinfo
        estado="Anulada"
        id="solicitudvehiculo_anulada"
        :api="url('/api/personal/' . auth()->id() . '/solicitudes')" :
        :items="['titulo'=>'Solicitud Vehiculo', 'mensaje'=>'Anuladas']"
        />
        <x-panelesinfo.cardinfo
        estado="Aprobada"
        id="solicitudvehiculo_aprobada"
        :api="url('/api/personal/' . auth()->id() . '/solicitudes')" :
        :items="['titulo'=>'Solicitud Vehiculo', 'mensaje'=>'Aprobadas']"
        />
        <ul>
            @foreach (session('personal') as $key => $dato)
                <li> {{ $key }} {{ $dato }} </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>
