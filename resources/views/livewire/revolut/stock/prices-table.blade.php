<table class="min-w-full divide-y divide-gray-200">
    <thead class="font-medium text-gray-500 uppercase tracking-wider
                                        text-center">
    <tr>
        <th>&nbsp;</th>
        <th class="px-6 py-3 text-xs hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            {{ __('When') }}
        </th>
        <th class="px-6 py-3 text-xs hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
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
        <th class="px-6 py-3 text-xs hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            {{ __('Ticker') }}
        </th>
        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ __('Quantity') }}
        </th>
        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ __('Price') }}
        </th>
        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ __('Total') }}
        </th>
    </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
    @forelse ($items as $key => $item)
        <tr class="even:bg-gray-50 odd:bg-white">
            <td title="{{ $item->hash }}">&nbsp;{{ $key+1 }}&nbsp;</td>
            <td class="px-3 py-2">
                {{ dateISO8601($item->date) }}
            </td>
            <td class="px-3 py-2 text-sm text-gray-500">
                {{ shorted($item->type ?? '') }}
            </td>
            <td class="px-3 py-2">
                {{ $item->ticker }}
            </td>
            <td class="px-3 py-2 text-right">
                {{ numberFormat($item->quantity, 3) }}
            </td>
            <td class="px-3 py-2">
                ${{ numberFormat($item->price) }}
            </td>
            <td class="px-3 py-2">
                {{ numberFormat($item->total) }}
            </td>
            <td class="text-right">
                @if($showButtons)
                    <a href="{{ route('stock.prices.details', [$item->ticker]) }}"
                       title="{{ $item->created_at }} | {{ $item->updated_at }}"
                       class="inline-flex items-center px-3 py-2 bg-gray-800
border border-transparent rounded-md
font-semibold text-xs text-white
uppercase tracking-widest
hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900
focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
transition ease-in-out duration-150"
                    >{{ __('details') }}</a>
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
