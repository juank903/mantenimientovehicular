@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'capitalize rounded text-xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm']) }}>
