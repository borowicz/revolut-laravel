<table class="min-w-full divide-y divide-gray-300 table-fixed">
    <thead class="font-medium uppercase text-gray-500 tracking-wider text-center">
    <tr>
        <th>&nbsp;</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 hover:bg-gray-300">
            @include('livewire.partials.button-sort-field', [
                'label' => 'market',
                'field' => 'name',
            ])
        </th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 hover:bg-gray-300">
            @include('livewire.partials.button-sort-field', [
                'label' => 'symbol',
                'field' => 'symbol',
            ])
        </th>
        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900 hover:bg-gray-300">
            @include('livewire.partials.button-sort-field', [
                'label' => 'country',
                'field' => 'country',
            ])
        </th>
        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">
            {{ __('suffixes') }}
        </th>
        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900 hover:bg-gray-300">
            @include('livewire.partials.button-sort-field', [
                'label' => 'status',
                'field' => 'disabled',
            ])
        </th>
    </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
    @forelse ($items as $key => $item)
        <tr class="even:bg-gray-50 odd:bg-white">
            <td title="{{ $item->hash }}">
                @include('revolutPartials::tooltip', ['ttTxt' => ((int)$key+1), 'ttComment' => $item->hash])</td>
            <td class="px-3 py-2" title="{{ $item->name }}">
                @if(empty($item->short_name))
                    {{ shorted($item->name ?? '') }}
                @else
                    {{ $item->short_name }}
                @endif
            </td>
            <td class="px-3 py-2 text-left">
                {{ $item->symbol ?? '' }}
            </td>
            <td class="px-3 py-2 text-left text-sm">
                {{ $item->country ?? '' }}
            </td>
            <td class="px-3 py-2 text-left text-sm text-gray-500">&nbsp;
[&nbsp;yF: {{ $item->suffix_yf ?? '' }}&nbsp;]&nbsp;
[&nbsp;gF: {{ $item->suffix_gf ?? ''  }}&nbsp;]&nbsp;
[&nbsp;FT: {{ $item->suffix_ft ?? ''  }}&nbsp;]&nbsp;
[&nbsp;BB: {{ $item->suffix_bb ?? ''  }}&nbsp;]&nbsp;
            </td>
            <td class="px-3 py-2 text-center text-sm text-gray-500">
                @include('livewire.partials.button-action', [
                    'label' => 'edit',
                    'routeName' =>'stock.markets.edit',
                    'itemId' => $item->id,
                ])
&nbsp;
                @include('livewire.partials.button-disable', [
                    'itemId' => $item->id,
                    'status' => $item->disabled,
                ])
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="px-3 py-2 text-center">
                {{ __('No items found') }}.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
