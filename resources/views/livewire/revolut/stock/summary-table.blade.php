<table class="min-w-full divide-y divide-gray-300 table-fixed">
    <thead class="font-medium text-gray-500 uppercase tracking-wider text-center">
    <tr>
        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ __('Ticker') }}
        </th>
        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ __('Quantity') }}
        </th>
        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ __('Total') }}
        </th>
        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ __('Spent') }}
        </th>
        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ __('Return') }}
        </th>
        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ __('Profit') }}
        </th>
        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ __('Current') }}
        </th>
        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ __('Diff') }}
        </th>
        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ __('AVG bought') }}
        </th>
        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ __('AVG Price') }}
        </th>
        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ __('Current value') }}
        </th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
    @forelse ($items['stocks'] as $ticker => $item)
        @if(empty($ticker))
            @continue
        @endif

        <tr class="even:bg-gray-50 odd:bg-white">
            <td class="px-3 py-2 whitespace-nowrap">
                <a href="{{ route('stock.details', ['ticker' => $item['ticker']]) }}" >{{ $item['ticker'] }}</a>
            </td>
            <td class="px-3 py-2 whitespace-nowrap text-right">
                {{ numberFormat($item['quantity']) }}
            </td>
            <td class="px-3 py-2 whitespace-nowrap text-right">
                {{ numberFormat($item['total']) }}
            </td>
            <td class="px-3 py-2 whitespace-nowrap text-right">
                {{ numberFormat($item['spent']) }}
            </td>
            <td class="px-3 py-2 whitespace-nowrap text-right">
                {{ numberFormat($item['return']) }}
            </td>
            <td class="px-3 py-2 whitespace-nowrap text-right  {{ $item['currentProfit'] < 0 ? 'text-rose-800' : '' }}">
                {{ numberFormat($item['currentProfit']) }}
            </td>
            <td class="px-3 py-2 whitespace-nowrap text-right">
                {{ numberFormat($item['currentValue']) }}
            </td>
            <td class="px-3 py-2 whitespace-nowrap text-right {{ $item['diff'] < 0 ? 'text-rose-800' : '' }}">
                {{ numberFormat($item['diff']) }}
            </td>
            <td class="px-3 py-2 whitespace-nowrap text-right">
                {{ numberFormat($item['currentValue']) }}
            </td>
            <td class="px-3 py-2 whitespace-nowrap text-right"
                title="{{ ($item['latestPrice'] ?? 0) }}">
                {{ numberFormat($item['avgBuy']) }}
            </td>
            <td class="px-3 py-2 whitespace-nowrap text-right {{ $item['avgCurrentAlert'] ? 'text-red-800' : '' }}"
                title="{{ ($item['latestDate'] ?? '') }}">
                {{ numberFormat($item['avgCurrent']) }}
            </td>
            <td class="px-3 py-2 whitespace-nowrap">
                <a href="{{ route('stock.transactions.details', [$item['ticker'] ?? '']) }}"
                   title="{{ $item['latestDate'] ?? 'latestDate' }}"
                >
                    <svg class="w-6 h-6 text-gray-800 dark:text-white"
                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                         fill="currentColor" viewBox="0 0 17 14">
                        <path
                            d="M16 2H1a1 1 0 0 1 0-2h15a1 1 0 1 1 0 2Zm0 6H1a1 1 0 0 1 0-2h15a1 1 0 1 1 0 2Zm0 6H1a1 1 0 0 1 0-2h15a1 1 0 0 1 0 2Z"/>
                    </svg>
                </a>
            </td>
            <td>
                <svg class="w-6 h-6 text-gray-800 dark:text-white"
                     aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 20 18">
                    <path stroke="currentColor" stroke-linecap="round"
                          stroke-linejoin="round" stroke-width="2"
                          d="m1 14 3-3m-3 3 3 3m-3-3h16v-3m2-7-3 3m3-3-3-3m3 3H3v3"/>
                </svg>
            </td>
        </tr>

    @empty
        <tr>
            <td colspan="3" class="px-6 py-4 text-center">
                {{ __('No items found') }}.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
