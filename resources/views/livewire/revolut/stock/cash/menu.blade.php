<a href="{{ route('stock.cash.create') }}"
   title="{{ __('add current cash available') }}"
   class="inline-flex items-center px-4 py-2 rounded-md
   font-semibold text-xs text-white uppercase
   {{ url()->current() == route('stock.cash.create') ? 'bg-gray-500' : 'bg-gray-800' }}
   active:bg-gray-500 active:text-gray-700
   hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100
   transition ease-in-out duration-150"
>{{ __('create') }}</a>
