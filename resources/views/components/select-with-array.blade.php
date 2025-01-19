@props(['items' => ['default'], 'indice' => [1]])

<select
    {{ $attributes->merge(['class' => 'text-xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm block mt-1 w-full']) }}>
    <option value=" "> </option>
    @foreach ($items as $index => $item)
        @if ($index === 0)
            <option value=" "> </option>
        @endif
        @if ($index === $indice)
            <option id="{{ $items->pluck('id_circuito_dependencias')[$index] }}" selected
                value="{{ $items->pluck('nombre_subcircuito_dependencias')[$index] }}">
                {{ $items->pluck('nombre_subcircuito_dependencias')[$index] }}</option>
        @else
            <option id="{{ $items->pluck('id_circuito_dependencias')[$index] }}"
                value="{{ $items->pluck('nombre_subcircuito_dependencias')[$index] }}">
                {{ $items->pluck('nombre_subcircuito_dependencias')[$index] }}</option>
        @endif
    @endforeach
</select>
