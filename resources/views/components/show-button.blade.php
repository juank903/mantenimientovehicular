
@props(['href' => '#', 'userId' => null])

<a href="{{ $href }}" data-id="{{ $userId }}" class="show-button">
    <svg class="h-5 w-5 text-blue-300 hover:text-blue-900"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r="2" />  <path d="M2 12l1.5 2a11 11 0 0 0 17 0l1.5 -2" />  <path d="M2 12l1.5 -2a11 11 0 0 1 17 0l1.5 2" /></svg>
</a>
