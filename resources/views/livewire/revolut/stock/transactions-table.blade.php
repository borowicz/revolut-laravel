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
            <td class="px-3 py-2">
                {{ $item->ticker }}
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
                    <a href="{{ route('stock.transactions.details', [$item->ticker]) }}"
                       title="{{ $item->created_at }} | {{ $item->updated_at }}"
                       class="inline-flex items-center px-2 py-2 bg-gray-800
border border-transparent rounded-md
font-semibold text-xs text-white
uppercase tracking-widest
hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900
focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
transition ease-in-out duration-150"
                    >{{ __('details') }}</a>
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
