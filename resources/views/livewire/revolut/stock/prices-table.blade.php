<table class="min-w-full divide-y divide-gray-300 table-fixed">
    <thead class="font-medium text-gray-500 uppercase tracking-wider text-center">
    <tr>
        <th>&nbsp;</th>
        <th class="text-center">
            @include('livewire.partials.text-sort-field', [
                'label' => 'when',
                'field' => 'day',
            ])
        </th>
        <th class="text-center">
            @include('livewire.partials.text-sort-field', [
                'label' => 'ticker',
                'field' => 'ticker',
            ])
        </th>
        <th>{{ __('Close') }}</th>
        <th>{{ __('Open') }}</th>
        <th>{{ __('High') }}</th>
        <th>{{ __('Low') }}<th>

    </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
    @forelse ($items as $key => $item)
        <tr class="even:bg-gray-50 odd:bg-white">
            <td title="{{ $item->hash }}">
                @include('revolutPartials::tooltip', ['ttTxt' => ((int)$key+1), 'ttComment' => $item->hash])</td>
            <td class="px-3 py-2">
                {{ dateISO8601($item->day) }}
            </td>
            <td class="px-3 py-2 text-left">
                <a href="{{ route('stock.details', ['ticker' => $item->ticker]) }}">{{ $item->ticker }}</a>
            </td>
            <td class="px-3 py-2 text-right text-sm">
                {{ numberFormat($item->close) }}&nbsp;$&nbsp;
            </td>
            <td class="px-3 py-2 text-right text-sm text-gray-500">
                {{ numberFormat($item->open, 5) }}
            </td>
            <td class="px-3 py-2 text-right text-sm text-gray-500">
                {{ numberFormat($item->high, 5) }}
            </td>
            <td class="px-3 py-2 text-right text-sm text-gray-500">
                {{ numberFormat($item->low ) }}
            </td>
            <td class="px-3 py-2 text-center text-sm text-gray-500">
                {{ shorted($item->source ?? '') }}
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
