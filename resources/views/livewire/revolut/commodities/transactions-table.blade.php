<table class="min-w-full divide-y divide-gray-300 table-fixed">
    <thead class="font-medium text-gray-500 uppercase tracking-wider text-center">
    <tr>
        <th>&nbsp;</th>
        <th class="text-center">
            @include('livewire.partials.text-sort-field', [
                'label' => 'when',
                'field' => 'started_date',
            ])
        </th>
        <th class="text-left">
            @include('livewire.partials.text-sort-field', [
                'label' => 'type',
                'field' => 'type',
            ])
        </th>
        <th class="text-left">
            @include('livewire.partials.text-sort-field', [
                'label' => 'ticker',
                'field' => 'currency',
            ])
        </th>
        <th class="text-left">
            {{ __('quantity') }}
        </th>
        <th class="text-left">
            {{ __('price') }}
        </th>
        <th class="text-left">
            {{ __('total') }}
        </th>
    </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
    @forelse ($items as $key => $item)
        <tr class="even:bg-gray-50 odd:bg-white">
            <td title="{{ $item->hash }}">&nbsp;{{ (int)$key+1 }}&nbsp;</td>
            <td class="px-3 py-2">
                {{ dateISO8601($item->completed_date) }}
            </td>
            <td class="px-3 py-2 text-sm">
                {{ shorted($item->currency) }}
            </td>
            <td class="px-3 py-2 text-sm">
                {{ shorted($item->type) }}
            </td>
            <td class="px-3 py-2 text-sm">
                {{ shorted($item->description) }}
            </td>
            <td class="px-3 py-2 text-sm">
                {{ shorted($item->amount) }}
            </td>
            <td class="px-3 py-2 text-sm">
                {{ shorted($item->fee) }}
            </td>
            <td class="px-3 py-2 text-sm">
                {{ shorted($item->balance) }}
            </td>
            <td class="text-right">
                @if($showButtons)
                    <a href="{{ route('commodities.transactions.details', ['ticker' => $item->currency, 'hash' => $item->hash]) }}"
                       title="{{ $item->created_at }} | {{ $item->updated_at }}"
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
