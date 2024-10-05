<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Markets') }}</h1>
                            <p class="mt-2 text-sm text-gray-700">..</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">

                            <a href="{{ route('markets.create') }}"
                               title="{{ __('markets list') }}"
                               class="inline-flex items-center px-4 py-2 rounded-md
   font-semibold text-xs text-white uppercase
   {{ url()->current() == route('markets.create') ? 'bg-gray-500' : 'bg-gray-800' }}
   active:bg-gray-500 active:text-gray-700
   hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100
   transition ease-in-out duration-150"
                            >{{ __('Add market') }}</a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            @include('livewire.pages.stock.menu')
                        </div>
                    </div>
                    <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300 table-fixed">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="px-6 py-3 pl-4 pr-2 text-left text-sm font-semibold text-gray-900 sm:pl-0"
                                            >&nbsp;</th>
                                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-900"
                                            >{{ __('name') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-900"
                                            >{{ __('short name') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-900"
                                            >{{ __('contry') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-900"
                                            >{{ __('suffixes') }}</th>
                                        <th scope="col" colspan="3">
                                            {{ __('actions') }}
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                    @foreach($items as $key => $item)
                                        <tr class="even:bg-gray-50 odd:bg-white">
                                            <td title="{{ $item->id }}">&nbsp;{{ $key+1 }}&nbsp;</td>
                                            <td class="px-3 py-2">{{ $item->name ?? '' }}</td>
                                            <td class="px-3 py-2 text-sm text-gray-500">{{ $item->short_name ?? '' }}</td>
                                            <td class="px-3 py-2 text-sm text-gray-500">{{ $item->country ?? '' }}</td>
                                            <td class="px-3 py-2 text-sm text-gray-500">
                                                <span class="size-0.5">
                                                    &nbsp;
                                                    <span title="">{{ $item->suffix ?? '' }}</span>&nbsp;
                                                    <span title="">{{ $item->suffix_ft ?? '' }}</span>&nbsp;
                                                    <span title="">{{ $item->suffix_bb ?? '' }}</span>&nbsp;
                                                    <span title="">{{ $item->suffix_gf ?? '' }}</span>&nbsp;
                                                </span>
                                            </td>

                                            <td class="relative whitespace-nowrap py-1 pl-1 pr-1 text-right text-sm font-medium sm:pr-0">
                                                <a href="{{ $item->id > 0 ? route('markets.edit', ['market' => $item->id]) : '#' }}"
                                                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                                                >{{ __('edit') }}</a>
                                            </td>
                                            <td class="relative whitespace-nowrap py-1 pl-1 pr-1 text-right text-sm font-medium sm:pr-0">
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
                                            </td>
                                            <td class="relative whitespace-nowrap py-1 pl-1 pr-1 text-right text-sm font-medium sm:pr-0">
                                                <a href="#"
                                                   wire:click="delete({{ $item->id }})"
                                                   class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                                >{{ __('delete') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
