<button wire:click="updateStatus('{{ $itemId }}', '{{ $status }}')"
        class="inline-flex items-center px-4 py-2 rounded-md
   font-semibold text-xs text-white uppercase
   {{ ($status > 0) ? 'bg-gray-500' : 'bg-gray-800' }}
   active:bg-gray-500 active:text-gray-700
   hover:bg-gray-100 hover:text-gray-900
   transition ease-in-out duration-150"
>
    @if ($status > 0)
    {{ __('disabled') }}
    @else
    {{ __('enabled') }}
    @endif
</button>
