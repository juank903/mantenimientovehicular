@props(['estado', 'items', 'id', 'api'])
{{-- @php
    dd(session('subcircuito'));
@endphp --}}
@php
    $classesContenedor = 'h-40 max-w-40 inline-block rounded-xl shadow-md p-4 flex flex-col items-center justify-center';
    $classesTextosDescriptivos = 'font-normal text-center';
    $classesTextoCifra = 'font-semibold text-5xl tracking-tight text-center';
    if ($estado == 'Aprobada') {
        //echo ('aprobado');
        $classesContenedor .= ' bg-green-300';
        $classesTextosDescriptivos .= ' text-green-600';
        $classesTextoCifra .= ' text-green-700';
    }
    if ($estado == 'Pendiente') {
        //echo ('pendiente');
        $classesContenedor .= ' bg-orange-300';
        $classesTextosDescriptivos .= ' text-orange-600';
        $classesTextoCifra .= ' text-orange-700';
    }
    if ($estado == 'Anulada') {
        //echo ('anulado');
        $classesContenedor .= ' bg-red-300';
        $classesTextosDescriptivos .= ' text-red-600';
        $classesTextoCifra .= ' text-red-700';
    }
@endphp

<div {{ $attributes->merge(['class' => $classesContenedor]) }}>
    <div id="{{ $id }}" {{ $attributes->merge(['class' => $classesTextoCifra]) }} ></div>
    <div {{ $attributes->merge(['class' => $classesTextosDescriptivos]) }}>{{ $items['titulo'] }}</div>
    <div {{ $attributes->merge(['class' => $classesTextosDescriptivos]) }}>{{ $items['mensaje'] }}</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: `{{ $api }}`,
            type: 'GET',
            success: function(response) {
                // Llenar el div con el ID 'dato' con la respuesta
                $('#{{ $id }}').html(`
                        ${response.numero_solicitudes}
                    `);
            },
            error: function(xhr) {
                const sessionId =
                    "{{ auth()->id() }}"; // Pasando la variable de sesión
                console.log("id:" + sessionId);
                // Manejo de error en caso de que no se encuentre el personal
                $('#dato').html('<p>Error: No se encontró el personal.</p>');
            }
        });
    });
</script>
