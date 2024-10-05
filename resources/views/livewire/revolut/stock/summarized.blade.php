{{ __('summary') }}:<br/>
<div class="text-base/6">
    @if ($items['summary'] ?? false)
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

