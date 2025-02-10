@if (isset($lateral) && $lateral == 'logotipo-lateral')
    <div class="sm:border-b-0 md:border-t-0 md:border-r-0 md:border-b-0 border-gray-100 lg:w-full">

        <x-logopoliciahorizontal />

        <div class="lx:px-12 md:px-0 pb-12 justify-center">
            {{ $slot }}
        </div>
    </div>
@elseif (isset($lateral) && $lateral == 'logotipo-sin-borde')
    <div class="w-full">

        <x-logopoliciahorizontal />

        <div class="px-12 pb-12 justify-center">
            {{ $slot }}
        </div>
    </div>
@elseif (isset($lateral) && $lateral == 'borde')
    <div class="border-2 border-gray-100 w-full px-7 justify-center">
        {{-- <div class="px-7 justify-center"> --}}
            {{ $slot }}
        {{-- </div> --}}
    </div>
@endif
