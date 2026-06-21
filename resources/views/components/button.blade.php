@props(['color' => 'primary', 'size' => 'sm'])

@php
    $baseClasses = 'font-medium shadow-sm transition-colors duration-300 inline-flex items-center justify-center cursor-pointer';
    
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

<button {{ $attributes->merge(['type' => 'button', 'class' => "$baseClasses $sizeClasses $colorClasses"]) }}>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
    </svg>
    {{ $slot }}
</button>
