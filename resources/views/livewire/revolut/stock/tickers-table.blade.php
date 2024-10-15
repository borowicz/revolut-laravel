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
            {{ __('market') }}
        </th>
        <th class="text-left lowercase">
            {{ __('news services') }}
        </th>
        <th class="text-right">
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
            <td class="px-3 py-2" title="{{ $item->notes }}">
                <a href="{{ route('stock.details', ['ticker' => $item->ticker]) }}">{{ $item->ticker }}</a>
            </td>
            <td class="px-3 py-2 text-left">
                <a href="{{ route('stock.tickers.view', ['id' => $item->stockMarket->id ?? 0]) }}">
                {{ $item->stockMarket->name ?? '' }}</a>
            </td>
            <td class="px-3 py-2 text-left text-sm text-gray-500">

                @include('livewire.partials.tooltip-href', [
                    'url' => newsUrl('yf', $item->ticker, ''),
                    'urlTxt' => '[yF]',
                    'urlCmt' => ' Yahoo Finance - ' . $item->ticker,
                ])

                @include('livewire.partials.tooltip-href', [
                    'url' => newsUrl('gf', $item->ticker, $item->suffix_gf ?? 'NASDAQ'),
                    'urlTxt' => '[gF]',
                    'urlCmt' => ' GooGle Finance - ' . $item->ticker,
                ])

                @include('livewire.partials.tooltip-href', [
                    'url' => newsUrl('ft', $item->ticker, $item->suffix_ft ?? 'NSQ'),
                    'urlTxt' => '[FT]',
                    'urlCmt' => ' ft.com - ' . $item->ticker,
                ])

                @include('livewire.partials.tooltip-href', [
                    'url' => newsUrl('cn', $item->ticker, ''),
                    'urlTxt' => '[CNN]',
                    'urlCmt' => ' cnn.com - ' . $item->ticker,
                ])

                @include('livewire.partials.tooltip-href', [
                    'url' => newsUrl('bb', $item->ticker, $item->suffix_gf ?? 'US'),
                    'urlTxt' => '[BB]',
                    'urlCmt' => ' bloomberg.com - ' . $item->ticker,
                ])

            </td>
            <td class="px-3 py-2 text-center text-sm text-gray-500">
                @include('livewire.partials.button-action', [
                    'label' => 'edit',
                    'routeName' =>'stock.tickers.edit',
                    'itemId' => $item->id,
                ])
                @include('livewire.partials.button-disable')
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="px-3 py-2 text-center">
                {{ __('No items found') }}.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
