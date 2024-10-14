<table class="min-w-full divide-y divide-gray-300">
    <thead class="font-medium uppercase text-gray-500 tracking-wider text-center">
    <tr>
        <th class="w-[30px]">&nbsp;</th>
        <th class="px-6 py-3 w-[250px]">
            @include('livewire.partials.button-sort-field', [
                'label' => 'title',
                'field' => 'title',
            ])
        </th>
        <th class="px-6 py-3 text-left">
            @include('livewire.partials.button-sort-field', [
                'label' => 'url',
                'field' => 'feed_url',
            ])
        </th>
        <th class="px-6 py-3 w-[200px]">
            @include('livewire.partials.button-sort-field', [
                'label' => 'status',
                'field' => 'disabled',
            ])
        </th>
        <th class="w-1">&nbsp;</th>
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
            <td class="px-3 py-2">
                @include('livewire.partials.button-disable')

                @include('livewire.partials.button-action', [
                        'label' => 'edit',
                        'routeName' =>'feeds.edit',
                        'itemId' => $item->id,
                    ])
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
