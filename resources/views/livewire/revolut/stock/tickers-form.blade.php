<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Tickers') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __($buttonAction) }}
                    </h2>
                    <div class="mt-1 text-sm text-gray-600">
                        @include('livewire.partials.sub-menu-button', ['menuRoute' => '$menuRoute', 'menuText' => 'tickers'])
                    </div>
                </header>

                <form wire:submit.prevent="save" class="mt-6 space-y-6">
                    <div>
                        <x-input-label for="disabled" :value="__('Disabled')" />
                        <x-text-input wire:model="disabled"
                                      id="disabled"
                                      name="disabled"
                                      type="text"
                                      class="mt-1 block w-full" required autofocus autocomplete="disabled" />
                        <x-input-error class="mt-2" :messages="$errors->get('disabled')" />
                    </div>

                    <div>
                        <x-input-label for="hash" :value="__('Hash')" />
                        <x-text-input wire:model="hash"
                                      id="hash"
                                      name="hash"
                                      type="text"
                                      class="mt-1 block w-full" required autocomplete="hash" />
                        <x-input-error class="mt-2" :messages="$errors->get('hash')" />
                    </div>

                    <div>
                        <x-input-label for="ticker" :value="__('Ticker')" />
                        <x-text-input wire:model="ticker"
                                      id="ticker"
                                      name="ticker"
                                      type="text"
                                      class="mt-1 block w-full" required autocomplete="ticker" />
                        <x-input-error class="mt-2" :messages="$errors->get('ticker')" />
                    </div>

                    <div>
                        <x-input-label for="url" :value="__('URL')" />
                        <x-text-input wire:model="url"
                                      id="url"
                                      name="url"
                                      type="text"
                                      class="mt-1 block w-full" required autocomplete="url" />
                        <x-input-error class="mt-2" :messages="$errors->get('url')" />
                    </div>

                    <div>
                        <x-input-label for="notes" :value="__('Notes')" />
                        <x-text-input wire:model="notes"
                                      id="notes"
                                      name="notes"
                                      type="text"
                                      class="mt-1 block w-full" required autocomplete="notes" />
                        <x-input-error class="mt-2" :messages="$errors->get('notes')" />
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
