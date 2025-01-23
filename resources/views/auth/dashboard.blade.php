<x-app-layout>
    @if (session('mensaje') || session('error'))
        @include('components.mensajemodalexito')
    @endif
    <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2 mt-10 z-0 text-sm">
        <x-panelesinfo.cardinfo/>
        <ul>
            @foreach (session('personal') as $key => $dato)
                <li> {{ $key }} {{ $dato }} </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>
