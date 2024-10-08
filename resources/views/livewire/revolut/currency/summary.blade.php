<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Commodities transactions list') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-sm sm:rounded-lg text-gray-900">

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto pt-6">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Summary') }}</h1>
                    <p class="mt-2 text-sm text-gray-700">...</p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    @php
                        $menuItems = [
                            'stock' => 'stock.index',
                            'crypto' => 'crypto.index',
                            'commodities' => 'commodities.index',
                        ];
                    @endphp
                    @include('livewire.partials.sub-menu')
                </div>
            </div>
        </div>

        <div class="px-4 sm:px-6 lg:px-8">
            @include('livewire.revolut.currency.currency-table')
        </div>
        <br class="clearfix"/>
    </div>
</div>

