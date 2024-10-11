<table class="min-w-full divide-y divide-gray-300 table-fixed">
    <thead class="font-medium uppercase text-gray-500 tracking-wider text-center">
    <tr>
        <th>&nbsp;</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 hover:bg-gray-300">
            @include('livewire.partials.button-sort-field', [
                'label' => 'market',
                'field' => 'name',
            ])
        </th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 hover:bg-gray-300">
            @include('livewire.partials.button-sort-field', [
                'label' => 'symbol',
                'field' => 'symbol',
            ])
        </th>
        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900 hover:bg-gray-300">
            @include('livewire.partials.button-sort-field', [
                'label' => 'country',
                'field' => 'country',
            ])
        </th>
        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">
            {{ __('suffixes') }}
        </th>
        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">
            {{ __('actions') }}
        </th>
        <th class="px-6 py-3 text-right text-sm lowercase hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            @include('livewire.partials.button-sort-field', [
                'label' => 'status',
                'field' => 'disabled',
            ])
        </th>
    </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
    @forelse ($items as $key => $item)
        <tr class="even:bg-gray-50 odd:bg-white">
            <td title="{{ $item->hash }}">
                @include('revolutPartials::tooltip', ['ttTxt' => ((int)$key+1), 'ttComment' => $item->hash])</td>
            <td class="px-3 py-2" title="{{ $item->name }}">
                @if(empty($item->short_name))
                    {{ shorted($item->name ?? '') }}
                @else
                    {{ $item->short_name }}
                @endif
            </td>
            <td class="px-3 py-2 text-left">
                {{ $item->symbol ?? '' }}
            </td>
            <td class="px-3 py-2 text-left text-sm">
                {{ $item->country ?? '' }}
            </td>
            <td class="px-3 py-2 text-right text-sm text-gray-500">

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
