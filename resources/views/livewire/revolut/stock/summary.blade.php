<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Stock summary') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-sm sm:rounded-lg text-gray-900">

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto pt-6">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Stock') }}</h1>
                    <p class="mt-2 text-sm text-gray-700">...</p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    @include('revolut::stock.menu')
                </div>
            </div>
        </div>

        <div class="px-4 sm:px-6 lg:px-8">
            @include('livewire.revolut.stock.summarized')
        </div>
        <div class="px-4">
{{--            @include('livewire.partials.accordion-modal') --}}
{{--            @include('livewire.revolut.stock.form-calculator')--}}
            @include('livewire.partials.accordion-calc')
        </div>
        <div class="px-4">
            @include('livewire.revolut.stock.summary-table')
        </div>
        @if($detailsView)
            <div class="px-6 py-10">
                @include('trading-view-widget')
            </div>
        @endif
        <br class="clearfix"/>
    </div>
</div>

