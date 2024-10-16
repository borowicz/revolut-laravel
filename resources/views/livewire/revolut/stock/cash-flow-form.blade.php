<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Current available cash') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('add current money/cash value') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        ...
                    </p>
                </header>

                <form wire:submit.prevent="save" class="mt-6 space-y-6">
                    <div class="py-3">
                        <div class="grid grid-cols-2 gap-1">
                            <div>
                                <x-input-label for="date" :value="__('when')" />
                                <x-text-input wire:model="date"
                                              id="date"
                                              name="date"
                                              type="text"
                                              value="{{ $date ?? '' }}"
                                              readonly="readonly"
                                              class="mt-1 block w-full bg-gray-100 text-black"/>
                                <x-input-error class="mt-2" :messages="$errors->get('date')" />
                            </div>
                            <div>
                                <x-input-label for="title" :value="__('cash value')" />
                                <x-text-input wire:model="total"
                                              id="total"
                                              name="total"
                                              type="text"
                                              value="{{ $total ?? 0 }}"
                                              class="mt-1 block w-full" required autofocus/>
                                <x-input-error class="mt-2" :messages="$errors->get('cash')" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __($buttonAction) }}</x-primary-button>
                        &nbsp;
                        <button type="button"
                                class="inline-flex items-center px-4 py-2 rounded-md
                                       font-semibold text-xs text-white uppercase
                                       active:bg-gray-500 active:text-gray-700
                                       hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100
                                       bg-gray-500
                                       transition ease-in-out duration-150"
                                wire:click="cancel">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
