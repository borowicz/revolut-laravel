<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Crypto summary') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-sm sm:rounded-lg text-gray-900">

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto pt-6">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">{{ $title ?? '' }} {{ __('Summary') }}</h1>
                    <p class="mt-2 text-sm text-gray-700">...</p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    @if (!empty($items['menu'] ?? ''))
                        @include($items['menu'])
                    @endif
                </div>
            </div>
        </div>
        <div class="py-3">
            <div class="grid grid-cols-2 gap-1">
                <div>
                    @if (isset($items['types']))
                        @foreach($items['types'] as $type)
                            {{ $type['type'] }}: {{ numberFormat($type['cnt'], 0) }}<br>
                        @endforeach
                    @endif
                </div>
                <div>
                    <div class="grid grid-cols-2 gap-1 w-96">
                        @if (isset($items['tickers']))
                            @foreach($items['tickers'] as $ticker)
                                <div class="text-right w-24">{{ $ticker->symbol }}: </div>
                                <div class="text-right w-48">{{ numberFormat($ticker->total, 6) }}</div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="px-4 sm:px-6 lg:px-8">

        </div>

        <div class="px-4 py-4 sm:px-6 lg:px-8">

        </div>
        <br class="clearfix"/>
    </div>
</div>

