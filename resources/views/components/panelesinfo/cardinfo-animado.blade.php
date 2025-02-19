@props(['estado', 'items', 'id', 'api'])

@php
    $classesContenedor = ' shadow-xs p-2 flex flex-col items-center justify-center';
    $classesTextosDescriptivos = 'text-xs font-normal text-center';
    $classesTextoCifra = 'font-semibold text-xl tracking-tight text-center';
    if ($estado == 'Aprobada') {
        //echo ('aprobada');
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
        //echo ('anulada');
        $classesContenedor .= ' bg-red-300';
        $classesTextosDescriptivos .= ' text-red-600';
        $classesTextoCifra .= ' text-red-700';
    }
    if ($estado == 'Completa') {
        //echo ('completa');
        $classesContenedor .= ' bg-blue-300';
        $classesTextosDescriptivos .= ' text-blue-600';
        $classesTextoCifra .= ' text-blue-700';
    }
    if ($estado == 'Procesando') {
        //echo ('completa');
        $classesContenedor .= ' bg-yellow-300';
        $classesTextosDescriptivos .= ' text-yellow-600';
        $classesTextoCifra .= ' text-yellow-700';
    }
    if ($estado == 'User') {
        //echo ('completa');
        $classesContenedor = ' ';
        $classesTextosDescriptivos = ' text-xs text-gray-400';
        $classesTextoCifra = ' font-bold text-gray-700 text-xl';
    }
@endphp

<div {{ $attributes->merge(['class' => $classesContenedor]) }}>
    <div id="{{ $id }}" {{ $attributes->merge(['class' => $classesTextoCifra]) }}></div>
    <div {{ $attributes->merge(['class' => $classesTextosDescriptivos]) }}>{{ $items['titulo'] }}</div>
    <div {{ $attributes->merge(['class' => $classesTextosDescriptivos]) }}>{{ $items['mensaje'] }}</div>
</div>

<script>
    // Función para obtener el valor de la API
    async function fetchData() {
        try {
            const response = await fetch(`{{ $api }}`); // Cambia la URL por la de tu API
            const data = await response.json();
            return data.numero_solicitudes; // Asume que la API devuelve un objeto con un campo "value"
        } catch (error) {
            console.error('Error fetching data:', error);
            return 0;
        }
    }

    // Función para animar el conteo
    function animateValue(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            element.textContent = Math.floor(progress * (end - start) + start);
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // Función principal
    async function main() {
        const value = await fetchData();
        const counterElement = document.getElementById('{{ $id }}');
        animateValue(counterElement, 0, value, 300); // 2000ms = 2 segundos de animación
    }

    main();
</script>
