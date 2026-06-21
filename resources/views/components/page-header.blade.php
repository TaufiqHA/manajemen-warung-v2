@props(['title', 'subtitle' => null])

<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">{{ $title }}</h1>
        @if($subtitle)
            <p class="text-gray-600 mt-1">{{ $subtitle }}</p>
        @endif
    </div>
    @if($slot->isNotEmpty())
        <div class="flex-shrink-0">
            {{ $slot }}
        </div>
    @endif
</div>
