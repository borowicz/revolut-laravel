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
            {{ __('currency') }}
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
            <td class="px-3 py-2" title="{{ $item->notes }}">
                {{ $item->symbol }}
            </td>
            <td class="px-3 py-2 text-left">
                {{ $item->currency ?? '' }}
            </td>
            <td class="px-3 py-2 text-left text-sm text-gray-500">

                [<a target="_blank"
                    href="https://finance.yahoo.com/quote/{{ $item->symbol }}-{{ $item->currency }}/?.tsrc={{ config('revolut.source') }}"
                >{{ __('financeYahoo') }}</a>],&nbsp;
                [<a target="_blank"
                    href="https://www.google.com/finance/quote/{{ $item->symbol }}-{{ $item->currency }}{{ config('revolut.source') }}"
                >{{ __('gFinance') }}</a>],&nbsp;
                [<a target="_blank"
                    href="https://edition.cnn.com/markets/stocks/{{ $item->symbol }}{{ config('revolut.source') }}"
                >{{ __('CNN') }}</a>],&nbsp;
                [<a target="_blank"
                    href="https://www.bloomberg.com/quote/{{ $item->symbol }}:{{ $item->suffix_bb ?? 'US' }}{{ config('revolut.source') }}"
                >{{ __('BB') }}</a>]
            </td>
            <td class="px-3 py-2 text-center text-sm text-gray-500">
                @include('livewire.partials.button-action', [
                    'label' => 'edit',
                    'routeName' =>'crypto.tickers.create',
                    'itemId' => $item->id,
                ])
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
