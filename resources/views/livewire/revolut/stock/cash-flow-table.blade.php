<table class="min-w-full divide-y divide-gray-300 table-fixed">
    <thead class="font-medium text-gray-500 uppercase tracking-wider text-center">
    <tr>
        <th>&nbsp;</th>
        <th class="text-left">
            @include('livewire.partials.text-sort-field', [
                'label' => 'when',
                'field' => 'date',
            ])
        </th>
        <th class="text-right">
            @include('livewire.partials.text-sort-field', [
                'label' => 'value',
                'field' => 'total',
            ])
        </th>
        <th class="text-center">
    </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
    @foreach($items as $key => $item)
        <tr class="even:bg-gray-50 odd:bg-white">
            <td title="{{ $item->id }}">
                @include('revolutPartials::tooltip', ['ttTxt' => ((int)$key+1), 'ttComment' => $item->hash])</td>
            <td class="px-3 py-2">{{ $item->date ?? '' }}</td>
            <td class="px-3 py-2 text-right">{{ numberFormat($item->total ?? 0) }}</td>
            <td class="px-3 py-2 text-center text-sm text-gray-500">
                @include('livewire.partials.button-edit', [
                         'label' => 'edit',
                         'routeName' =>'stock.cash.flow.edit',
                         'item' => $item
                ])
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
