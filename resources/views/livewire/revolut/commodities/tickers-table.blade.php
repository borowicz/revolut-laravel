<table class="min-w-full divide-y divide-gray-300 table-fixed">
    <thead class="font-medium text-gray-500 uppercase tracking-wider text-center">
    <tr>
        <th>&nbsp;</th>
        <th class="text-center">
            @include('livewire.partials.text-sort-field', [
                'label' => 'ticker',
                'field' => 'ticker',
            ])
        </th>
        <th class="text-center lowercase">
            {{ __('currency') }}
        </th>
        <th class="text-center">
            &nbsp;
        </th>
    </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
    @forelse ($items as $key => $item)
        <tr class="even:bg-gray-50 odd:bg-white">
            <td title="{{ $item->hash }}">&nbsp;{{ (int)$key+1 }}&nbsp;</td>
            <td class="px-3 py-2" title="{{ $item->notes }}">
                {{ $item->ticker }}
            </td>
            <td class="px-3 py-2 text-left">
                {{ $currency[$item->ticker] ?? '' }}
            </td>
            <td class="px-3 py-2 text-right text-sm text-gray-500">
{{--                @include('livewire.partials.button-action', [
                    'label' => 'edit',
                    'routeName' =>'commodities.tickers.edit',
                    'itemId' => $item->id,
                ])--}}
                @include('livewire.partials.button-disable')
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="px-3 py-2 text-center">
                {{ __('No items found') }}.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
