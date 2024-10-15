<button wire:click="sortBy('{{ $field }}')" class="flex items-center space-x-1">
    <span class="uppercase">{{ __($label) }}</span>
    @if ($sortField === $field)
        @if ($sortDirection === 'asc')
            <!-- Up Arrow Icon -->
            <svg class="w-4 h-4 text-gray-600" fill="currentColor"
                 viewBox="0 0 20 20">
                <path d="M5 10l5-5 5 5H5z"/>
            </svg>
        @else
            <svg class="w-4 h-4 text-gray-600" fill="currentColor"
                 viewBox="0 0 20 20">
                <path d="M15 10l-5 5-5-5h10z"/>
            </svg>
        @endif
    @endif
</button>
