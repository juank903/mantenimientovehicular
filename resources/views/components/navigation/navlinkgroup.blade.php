@props(['active', 'items'])

@php
    $classes =
        $active ?? false
            ? 'cursor-default inline-flex items-center  pt-1 border-b-2 border-indigo-400 text-xs font-medium leading-5 text-slate-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'cursor-default inline-flex items-center  pt-1 border-b-2 border-transparent text-xs font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<div class="relative group pt-1 z-50 mt-4">
    <button {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
    <div class="absolute left-0 hidden mt-2 w-48 bg-white shadow-lg group-hover:block">
        @foreach ($items as $enlace => $ruta)
            @php
                //$patron = '/,\s*\[.*\]/';
                $partes = explode(',', $ruta, 2);
                //(preg_match($patron, $ruta, $partes))
            @endphp
            @if (count($partes) === 2)
                @php
                    //dd($partes);
                    //$parametro = $partes[1];
                    //$nombreruta = str_replace("/{".$parametro."}","",$ruta);
                    $nombreruta = trim($partes[0]); // trim() para eliminar espacios en blanco
                    $parametros = trim($partes[1]); // trim() para eliminar espacios en blanco
                    $parametros = trim($parametros, '[]');

                    // Dividir la cadena en pares clave-valor
                    $pairs = explode(',', $parametros);

                    // Construir el array
                    $arrayParametros = [];
                    foreach ($pairs as $pair) {
                        [$key, $value] = explode('=>', $pair);
                        $key = trim($key, "' ");
                        $value = trim($value, "' ");
                        $arrayParametros[$key] = $value;
                    }
                @endphp
                <a href="{{ route($nombreruta, $arrayParametros) }}"
                    class="block px-4 py-2 text-xs font-medium leading-5  hover:bg-indigo-200 text-gray-500 hover:text-gray-900 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">{{ $enlace }}</a>

                {{-- <a href="{{route( name: $nombreruta, parameters: ['id'=>$parametro] )}}" class="block px-4 py-2 text-xs font-medium leading-5  hover:bg-indigo-200 text-gray-500 hover:text-gray-900 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">{{$enlace}}</a> --}}
                {{-- <a href="#" class="block px-4 py-2 text-xs font-medium leading-5  hover:bg-indigo-200 text-gray-500 hover:text-gray-900 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">{{$enlace}}</a> --}}
            @else
                <a href="{{ route($ruta) }}"
                    class="block px-4 py-2 text-xs font-medium leading-5  hover:bg-indigo-200 text-gray-500 hover:text-gray-900 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">{{ $enlace }}</a>
            @endif
        @endforeach
    </div>
</div>
