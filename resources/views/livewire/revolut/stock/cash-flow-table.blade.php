<table class="min-w-full divide-y divide-gray-300 table-fixed">
    <thead class="font-medium text-gray-500 uppercase tracking-wider text-center">
    <tr>
        <th scope="col" class="px-6 py-3 pl-4 pr-2 text-left text-sm font-semibold text-gray-900 sm:pl-0">&nbsp;</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            @include('livewire.partials.button-sort-field', [
                'label' => 'when',
                'field' => 'date',
            ])
        </th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            @include('livewire.partials.button-sort-field', [
                'label' => 'value',
                'field' => 'total',
            ])
        </th>
        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-900">&nbsp;</th>
    </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
    @foreach($items as $key => $item)
        <tr class="even:bg-gray-50 odd:bg-white">
            <td title="{{ $item->id }}">&nbsp;{{ (int)$key+1 }}&nbsp;</td>
            <td class="px-3 py-2">{{ $item->date ?? '' }}</td>
            <td class="px-3 py-2">{{ numberFormat($item->total ?? 0) }}</td>
            <td class="px-3 py-2 text-center text-sm text-gray-500">
                @include('livewire.partials.button-action', [
                    'label' => 'edit',
                    'routeName' =>'stock.cash.flow.edit',
                    'itemId' => $item->id,
                ])
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
