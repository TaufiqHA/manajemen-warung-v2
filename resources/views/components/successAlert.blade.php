@if(session('success'))
<div x-data="{ show: true }" 
     x-init="setTimeout(() => show = false, 3000)" 
     x-show="show" 
     x-transition.duration.500ms 
     class="mb-4 p-4 rounded-2xl bg-green-100 text-green-700 border border-green-200 shadow-sm flex justify-between items-center gap-3">
    
    <div class="flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>

    <button @click="show = false" class="text-green-700 hover:text-green-900 focus:outline-none">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>
@endif
