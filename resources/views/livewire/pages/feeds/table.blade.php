<table class="min-w-full divide-y divide-gray-300 table-fixed">
    <thead class="font-medium uppercase text-gray-500 tracking-wider text-center">
    <tr>
        <th>&nbsp;</th>
        <th class="px-6 py-3">
            @include('livewire.partials.button-sort-field', [
                'label' => 'title',
                'field' => 'title',
            ])
        </th>
        <th class="px-6 py-3">
            @include('livewire.partials.button-sort-field', [
                'label' => 'url',
                'field' => 'feed_url',
            ])
        </th>
        <th class="px-6 py-3">
            @include('livewire.partials.button-sort-field', [
                'label' => 'status',
                'field' => 'disabled',
            ])
        </th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
    @forelse ($items as $key => $item)
        <tr class="even:bg-gray-50 odd:bg-white">
            <td title="{{ $item->hash }}">&nbsp;{{ (int)$key+1 }}&nbsp;</td>
            <td class="px-3 py-2" title="{{ $item->notes }}">
                {{ $item->title }}
            </td>
            <td class="px-3 py-2 text-left">
                {{ $item->feed_url ?? '' }}
            </td>
            <td class="px-3 py-2 text-right text-sm text-gray-500">
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
