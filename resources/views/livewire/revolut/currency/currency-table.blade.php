<table class="min-w-full divide-y divide-gray-300 table-fixed">
    <thead class="font-medium text-gray-500 uppercase tracking-wider text-center">
    <tr>
        <th>&nbsp;</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            {{ __('When') }}
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
            <td>&nbsp;{{ (int)$key+1 }}&nbsp;</td>
            <td class="px-3 py-2">
                {{ $item->date ?? '' }}
            </td>
            <td class="px-3 py-2 text-sm">
                {{ $item->type ?? '' }}
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
