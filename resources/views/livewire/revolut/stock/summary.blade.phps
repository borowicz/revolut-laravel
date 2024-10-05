<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Current stock overview') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-sm sm:rounded-lg text-gray-900">
&nbsp;
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    @include('livewire.revolut.stock.menu')
                </div>
            </div>
        </div>

        <div class="px-4 sm:px-6 lg:px-8">
            @include('livewire.revolut.stock.summarized')
        </div>

        <div class="px-4 sm:px-6 lg:px-8">
            @include('livewire.revolut.stock.table')
        </div>
        <br class="clearfix"/>
    </div>
</div>

