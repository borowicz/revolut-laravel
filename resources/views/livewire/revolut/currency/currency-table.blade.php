<table class="min-w-full divide-y divide-gray-300 table-fixed">
    <thead class="font-medium text-gray-500 uppercase tracking-wider text-center">
    <tr>
        <th>&nbsp;</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            {{ __('When') }}
        </th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            @include('livewire.partials.button-sort-field', [
                'label' => 'ticker',
                'field' => 'symbol',
            ])
        </th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            {{ __('Code') }}
        </th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            {{ __('exchange rate') }}
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
            <td class="px-3 py-2 text-center text-sm">
                {{ $item->currency ?? '' }}
            </td>
            <td class="px-3 py-2 text-sm">
                {{ $item->code ?? '' }}
            </td>
            <td class="px-3 py-2">
                {{ $item->exchange_rate ?? '' }}
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
