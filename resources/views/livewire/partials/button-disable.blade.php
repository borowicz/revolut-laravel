<button wire:click="updateStatus('{{ $item['id'] }}', '{{ $item['disabled'] }}')"
        class="inline-flex items-center px-4 py-2 rounded-md
   font-semibold text-xs text-white uppercase
   {{ ($itemStatus[$item->id] > 0) ? 'bg-gray-800' : 'bg-gray-500' }}
   active:bg-gray-500 active:text-gray-700
   hover:bg-gray-100 hover:text-gray-900
   transition ease-in-out duration-150"
>
    @if ($itemStatus[$item->id] > 0)
    {{ __('disabled') }}
    @else
    {{ __('enabled') }}
    @endif
</button>
