<table class="min-w-full divide-y divide-gray-300 table-fixed">
    <thead class="font-medium text-gray-500 uppercase tracking-wider text-center">
    <tr>
        <th>&nbsp;</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 hover:bg-gray-300">
            {{ __('When') }}
        </th>
        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900 hover:bg-gray-300">
            @if(isset($sortField))
                <button wire:click="sortBy('type')"
                        class="flex items-center space-x-1">
                    <span>{{ __('Type') }}</span>
                    @if ($sortField === 'type')
                        @if ($sortDirection === 'asc')
                            <!-- Up Arrow Icon -->
                            <svg class="w-4 h-4 text-gray-600" fill="currentColor"
                                 viewBox="0 0 20 20">
                                <path d="M5 10l5-5 5 5H5z"/>
                            </svg>
                        @else
                            <!-- Down Arrow Icon -->
                            <svg class="w-4 h-4 text-gray-600" fill="currentColor"
                                 viewBox="0 0 20 20">
                                <path d="M15 10l-5 5-5-5h10z"/>
                            </svg>
                        @endif
                    @endif
                </button>
            @endif
        </th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 hover:bg-gray-300">
            {{ __('Ticker') }}
        </th>
        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900 hover:bg-gray-300">
            {{ __('Quantity') }}
        </th>
        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900 hover:bg-gray-300">
            {{ __('Price') }}
        </th>
        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900 hover:bg-gray-300">
            {{ __('Total') }}
        </th>
    </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
    @forelse ($items as $key => $item)
        <tr class="even:bg-gray-50 odd:bg-white">
            <td title="{{ $item->hash }}">&nbsp;{{ (int)$key+1 }}&nbsp;</td>
            <td class="px-3 py-2">
                {{ dateISO8601($item->completed_date) }}
            </td>
            <td class="px-3 py-2 text-sm">
                {{ shorted($item->currency) }}
            </td>
            <td class="px-3 py-2 text-sm">
                {{ shorted($item->type) }}
            </td>
            <td class="px-3 py-2 text-sm">
                {{ shorted($item->description) }}
            </td>
            <td class="px-3 py-2 text-sm">
                {{ shorted($item->amount) }}
            </td>
            <td class="px-3 py-2 text-sm">
                {{ shorted($item->fee) }}
            </td>
            <td class="px-3 py-2 text-sm">
                {{ shorted($item->balance) }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="3" class="px-3 py-2 text-center">
                {{ __('No items found') }}.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
