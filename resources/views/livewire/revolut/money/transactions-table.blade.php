<table class="min-w-full divide-y divide-gray-300 table-fixed">
    <thead class="font-medium text-gray-500 uppercase tracking-wider text-center">
    <tr>
        <th>&nbsp;</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            {{ __('When') }}
        </th>
        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
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
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            {{ __('Ticker') }}
        </th>
        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            {{ __('Quantity') }}
        </th>
        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            {{ __('Price') }}
        </th>
        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            {{ __('Total') }}
        </th>
    </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
    @forelse ($items as $key => $item)
        <tr class="even:bg-gray-50 odd:bg-white">
            <td title="{{ $item->hash }}">&nbsp;{{ (int)$key+1 }}&nbsp;</td>
            <td class="px-3 py-2">
                {{ dateISO8601($item->date) }}
            </td>
            <td class="px-3 py-2 text-sm">
                {{ shorted($item->type) }}
            </td>
            <td class="px-3 py-2">
                {{ $item->ticker }}
            </td>
            <td class="px-3 py-2 text-right text-sm">
                {{ numberFormat($item->quantity, 3) }}
            </td>
            <td class="px-3 py-2 text-right text-sm">
                ${{ numberFormat($item->price_per_share) }}
            </td>
            <td class="px-3 py-2 text-right">
                {{ numberFormat($item->total_amount) }}
            </td>
            <td class="text-right">
                @if($showButtons)
                    <a href="{{ route('money.transactions.details', ['hash' => $item->hash, 'ticker' => $item->ticker ?? 'none']) }}">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white"
                             aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 17 14">
                            <path d="M16 2H1a1 1 0 0 1 0-2h15a1 1 0 1 1 0 2Zm0 6H1a1 1 0 0 1 0-2h15a1 1 0 1 1 0 2Zm0 6H1a1 1 0 0 1 0-2h15a1 1 0 0 1 0 2Z"/>
                        </svg>
                    </a>
                @endif
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
