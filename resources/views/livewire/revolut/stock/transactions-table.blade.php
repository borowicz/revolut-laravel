<table class="min-w-full divide-y divide-gray-300 table-fixed">
    <thead class="font-medium text-gray-500 uppercase tracking-wider text-center">
    <tr>
        <th>&nbsp;</th>
        <th class="text-center">
            @include('livewire.partials.text-sort-field', [
                'label' => 'when',
                'field' => 'date',
            ])
        </th>
        <th>
            @include('livewire.partials.text-sort-field', [
                'label' => 'type',
                'field' => 'type',
            ])
        </th>
        <th>
            @include('livewire.partials.text-sort-field', [
                'label' => 'ticker',
                'field' => 'ticker',
            ])
        </th>
        <th>
            {{ __('Quantity') }}
        </th>
        <th>
            {{ __('Price') }}
        </th>
        <th>
            {{ __('Total') }}
        </th>
    </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
    @forelse ($items as $key => $item)
{{--        @dd($item)--}}
        <tr class="even:bg-gray-50 odd:bg-white">
            <td title="{{ $item->hash }}">&nbsp;
                @include('revolutPartials::tooltip', ['ttTxt' => ((int)$key+1), 'ttComment' => $item->hash])</td>
            <td class="px-3 py-2">
                {{ dateISO8601($item->date) }}
            </td>
            <td class="px-3 py-2 text-sm">
                {{ shorted($item->type) }}
            </td>
            <td>
{{--                <a href="{{ route('stock.transactions.list', ['ticker' => $item->ticker ?? '']) }}">--}}
                    {{ $item->ticker ?? '' }}
{{--                </a>--}}
            </td>
            <td class="px-3 py-2 text-right text-sm">
                {{ numberFormat($item->quantity, 3) }}
            </td>
            <td class="px-3 py-2 text-right text-sm">
                ${{ numberFormat($item->price_per_share) }}
            </td>
            <td class="px-3 py-2 text-right">
                {{ numberFormat($item->total_amount) }}
            </td>
            <td class="text-right">
                @if($showButtons)
                    <a
{{--                        href="{{ route('stock.transactions.details', ['hash' => $item->hash]) }}"--}}
                        href="{{ route('stock.transactions.details', ['hash' => $item->hash, 'ticker' => $item->ticker ?? 'none']) }}"
{{--                       title="{{ $item->created_at }} | {{ $item->updated_at | $item->ticker ?? 'none' }}"--}}
                    >
                        <svg class="w-6 h-6 text-gray-800 dark:text-white"
                             aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 17 14">
                            <path d="M16 2H1a1 1 0 0 1 0-2h15a1 1 0 1 1 0 2Zm0 6H1a1 1 0 0 1 0-2h15a1 1 0 1 1 0 2Zm0 6H1a1 1 0 0 1 0-2h15a1 1 0 0 1 0 2Z"/>
                        </svg>
                    </a>
                @endif
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
