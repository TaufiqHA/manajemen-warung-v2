@props(['color' => 'primary', 'size' => 'sm', 'icon' => null, 'isModal' => false])

@php
    // If it is in modal, we can remove the shadow or ensure the text is centered nicely, or provide specific styling
    $baseClasses = 'font-medium transition-colors duration-300 inline-flex items-center justify-center cursor-pointer';
    
    // Add shadow unless it's a modal button where we might want a flatter look, but let's keep shadow-sm
    $baseClasses .= ' shadow-sm';

    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1.5 rounded-xl text-sm',
        'md' => 'px-5 py-2 rounded-full text-base',
        'lg' => 'px-6 py-2.5 rounded-full text-base',
        default => 'px-3 py-1.5 rounded-xl text-sm',
    };

    $colorClasses = match($color) {
        'primary' => 'bg-[#2D735B] hover:bg-[#245D49] text-white',
        'warning' => 'bg-yellow-400 hover:bg-yellow-500 text-white',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white',
        'secondary' => 'bg-gray-100 hover:bg-gray-200 text-gray-600',
        'outline' => 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50',
        default => 'bg-[#2D735B] hover:bg-[#245D49] text-white',
    };
@endphp

<button {{ $attributes->merge(['type' => 'button', 'class' => "$baseClasses $sizeClasses $colorClasses" . ($isModal ? ' w-full sm:w-auto' : '')]) }}>
    @if($icon === 'plus')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
    @elseif($icon === 'edit')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
        </svg>
    @elseif($icon === 'trash')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
    @elseif($icon)
        {!! $icon !!}
    @endif
    {{ $slot }}
</button>
