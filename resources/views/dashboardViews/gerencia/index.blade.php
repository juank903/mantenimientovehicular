<x-app-layout>
    @if (session('mensaje') || session('error'))
        @include('components.mensajemodalexito')
    @endif
    Estoy en la vista gerencia

</x-app-layout>
