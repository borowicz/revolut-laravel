<table class="min-w-full divide-y divide-gray-300 table-fixed">
    <thead class="font-medium uppercase text-gray-500 tracking-wider text-center">
    <tr>
        <th>&nbsp;</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            @include('livewire.partials.button-sort-field', [
                'label' => 'ticker',
                'field' =>'ticker',
            ])
        </th>
        <th class="px-6 py-3 text-left lowercase">
            {{ __('market') }}
        </th>
        <th class="px-6 py-3 text-left lowercase">
            {{ __('news services') }}
        </th>
        <th class="px-6 py-3 text-center lowercase">
            &nbsp;
        </th>
        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            @include('livewire.partials.button-sort-field', [
                'label' => 'status',
                'field' =>'disabled',
            ])
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
                {{ $item->market ?? '' }}
            </td>
            <td class="px-3 py-2 text-left text-sm text-gray-500">

                [<a target="_blank"
                    href="https://finance.yahoo.com/quote/{{ $item->ticker }}/?.tsrc={{ config('revolut.source') }}"
                >{{ __('financeYahoo') }}</a>],&nbsp;
                [<a target="_blank"
                    href="https://www.google.com/finance/quote/{{ $item->ticker }}:{{ $item->suffix_gf ?? 'NASDAQ' }}{{ config('revolut.source') }}"
                >{{ __('gFinance') }}</a>],&nbsp;
                [<a target="_blank"
                    href="https://markets.ft.com/data/equities/tearsheet/summary?s={{ $item->suffix_ft }}{{ config('revolut.source') }}"
                >{{ __('FT') }}</a>],&nbsp;
                [<a target="_blank"
                    href="https://edition.cnn.com/markets/stocks/{{ $item->ticker }}{{ config('revolut.source') }}"
                >{{ __('CNN') }}</a>],&nbsp;
                [<a target="_blank"
                    href="https://www.bloomberg.com/quote/{{ $item->ticker }}:{{ $item->suffix_bb ?? 'US' }}{{ config('revolut.source') }}"
                >{{ __('BB') }}</a>]
            </td>
            <td class="px-3 py-2 text-center text-sm text-gray-500">
                @include('livewire.partials.button-action', [
                    'label' => 'edit',
                    'routeName' =>'stock.markets.edit',
                    'itemId' => $item->id,
                ])
            </td>
            <td class="px-3 py-2 text-right text-sm text-gray-500">
                @include('livewire.partials.button-disable', [
                    'itemId' => $item->id,
                    'status' => $item->disabled,
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
