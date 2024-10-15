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
        <th >{{ __('currency') }}</th>
        <th class="text-center">
            @include('livewire.partials.text-sort-field', [
                'label' => 'value',
                'field' => 'total_amount',
            ])
        </th>
        <th>{{ __('exchange') }}</th>
    </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
    @foreach($items as $key => $item)
        <tr class="even:bg-gray-50 odd:bg-white">
            <td title="{{ $item->id }}">
                @include('revolutPartials::tooltip', ['ttTxt' => ((int)$key+1), 'ttComment' => $item->hash])</td>
            <td class="px-3 py-2">{{ $item->date ?? '' }}</td>
            <td class="px-3 py-2 text-sm text-gray-500">{{ $item->currency ?? '' }}</td>
            <td class="px-3 py-2 text-right">{{ numberFormat($item->total_amount ?? 0) }}</td>
            <td class="px-3 py-2 text-right text-sm text-gray-500">{{ $calculated['transactions'][$item->hash]['exchange_rate'] ?? '' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
