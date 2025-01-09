@if (isset($lateral) && $lateral == 'logotipo-lateral')
    <div class="sm:border-b-0 md:border-t-2 md:border-r-2 md:border-b-2 border-gray-100 lg:w-full md:w-1/2">

        <x-logopoliciahorizontal />

        <div class="px-12 pb-12 justify-center">
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
    <div class="border-2 border-gray-100 w-full">
        <div class="px-12 pb-12 pt-12 justify-center">
            {{ $slot }}
        </div>
    </div>
@endif
