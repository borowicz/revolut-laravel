{{ __('calculations') }}:<br/>
<div class="text-sm">
    @if ($items['totalCash'] ?? false)
        {{ __('total top up cash') }}: {{ numberFormat($items['totalCash']) }},&nbsp;
    @endif
    @if ($items['totalValue'] ?? false)
        {{ __('total tickers value') }}: {{ numberFormat($items['totalValue']) }},&nbsp;
    @endif
    @if ($items['totalMoney'] ?? false)
        {{ __('current free money') }}: {{ numberFormat($items['totalMoney']) }},&nbsp;
    @endif
    @if ($items['totalMoney'] > 0 && $items['totalValue'] > 0)
        {{ __('sum') }}: {{ numberFormat($items['totalMoney'] + $items['totalValue']) }},&nbsp;
    @endif
    @if ($items['summary'] ?? false)
        <br />
        @if($items['summary']['cashTotal'])
            {{ __('invested') }}: {{ numberFormat($items['summary']['cashTotal'] ?? 0) }},
            <br/>
        @endif
        {{ __('total') }}: {{ numberFormat($items['summary']['total'] ?? 0) }},
        {{ __('left') }}
        : {{ numberFormat(($items['summary']['cashTotal'] + $items['summary']['total']) ?? 0) }}
        ,

        {{ __('dividend') }}: {{ numberFormat($items['summary']['dividend'] ?? 0) }},
        {{ __('fees') }}: {{ numberFormat($items['summary']['feesTotal'] ?? 0) }},
        {{ __('return') }}: {{ numberFormat($items['summary']['return'] ?? 0) }},
        {{ __('spent') }}: {{ numberFormat($items['summary']['spent'] ?? 0) }},
        {{ __('diff') }}
        : {{ numberFormat(($items['summary']['spent'] - $items['summary']['return']) ?? 0) }},
    @endif
</div>

