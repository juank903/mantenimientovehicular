<x-app-layout>
    @if (session('mensaje') || session('error'))
        <x-mensajemodalexito/>
    @endif
</x-app-layout>
