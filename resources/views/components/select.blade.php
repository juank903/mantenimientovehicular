@props(['items' => ['default'], 'indice' => [1]])

<select
    {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm block mt-1 w-full']) }}>
    @foreach ($items as $index => $item)
        @if ($index === $indice)
            <option selected value="{{ $item }}">{{ $item }}</option>
        @else
            <option value="{{ $item }}">{{ $item }}</option>
        @endif
    @endforeach
</select>
