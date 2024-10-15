<table class="min-w-full divide-y divide-gray-300 table-fixed">
    <thead class="font-medium text-gray-500 uppercase tracking-wider text-center">
    <tr>
        <th>&nbsp;</th>
        <th class="text-center">
            @include('livewire.partials.text-sort-field', [
                'label' => 'ticker',
                'field' => 'currency',
            ])
        </th>
        <th class="text-left lowercase">
            {{ __('amount') }}
        </th>
        <th class="text-left lowercase">
            {{ __('news services') }}
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
            <td class="px-3 py-2>
                @include('revolutPartials::tooltip', [
                    'ttTxt' => ($item->currency ?? ''),
                    'ttComment' => $item->currency ?? '' . ' ' . $item->description ?? ''
                        . ' ' . $item->product ?? '' . ' ' . $item->state ?? '' . ' ' . $item->type ?? '',
                ])
            </td>
            <td class="px-3 py-2 text-left">
                {{ $item->amount ?? '' }}
            </td>
            <td class="px-3 py-2 text-left text-sm text-gray-500">
                [<a target="_blank"
                    href="https://finance.yahoo.com/quote/{{ $item->ticker }}/?.tsrc={{ config('revolut.source') }}"
                >{{ __('financeYahoo') }}</a>],&nbsp;
            </td>
            <td class="px-3 py-2 text-center text-sm text-gray-500">
                @include('livewire.partials.button-action', [
                    'label' => 'details',
                    'routeName' =>'commodities.transactions.details',
                    'itemId' => $item->id,
                ])
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
