<div wire:click="sortBy('{{ $field }}')"
     class="px-2 py-2 text-sm font-semibold text-gray-900
            {{ ($sortField === $field) ? 'bg-gray-200' : '' }}
            hover:bg-gray-300">
    @if ($sortField === $field)
        <div class="float-right">
            @if ($sortDirection === 'asc')
                <!-- Up Arrow Icon -->
                <svg class="w-4 h-4 text-gray-600" fill="currentColor"
                     viewBox="0 0 20 20">
                    <path d="M5 10l5-5 5 5H5z"/>
                </svg> UP
            @else
                <svg class="w-4 h-4 text-gray-600" fill="currentColor"
                     viewBox="0 0 20 20">
                    <path d="M15 10l-5 5-5-5h10z"/>
                </svg>
            @endif
        </div>
    @endif
    <div class="uppercase">{{ __($label) }}</div>
</div>
