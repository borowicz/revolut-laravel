<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Tickers') }}
    </h2>
</x-slot>

<div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">

        <form wire:submit.prevent="save" class="mt-6 space-y-6">
            @csrf

            <header>
                <div class="float-right mt-1 text-sm text-gray-600">
                    @include('livewire.partials.sub-menu-button', ['menuRoute' => 'stock.tickers', 'menuText' => 'back'])
                </div>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __($buttonAction) }}
                </h2>
            </header>

            <div class="grid grid-cols-3 gap-4">

                <!-- Pole 'Hash' -->
                <div>
                    <x-input-label for="hash" :value="__('Hash')"/>
                    <x-text-input wire:model="hash"
                                  id="hash"
                                  name="hash"
                                  type="text"
                                  readonly="readonly"
                                  class="mt-1 block w-full" required autocomplete="hash"/>
                    <x-input-error class="mt-2" :messages="$errors->get('hash')"/>
                </div>

                <div>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="1"
                               wire:model="disabled"
                               id="disabled"
                               class="sr-only peer"
                               {{ !$disabled ?: 'checked' }}
                               wire:click="toggleDisabled('{{ $disabled }}')"
                        >
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-gray-300 dark:peer-focus:ring-gray-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-600"></div>
                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                            @if($disabled)
                                {{ __('Enabled') }}
                            @else
                                {{ __('Disabled') }}
                            @endif
                        </span>
                    </label>
                </div>

                <!-- Checkbox 'Disabled' -->
                <div class="text-sm">
                    {{ __('created') }} {{ $entryInfo['created_at'] ?? '' }}<br/>
                    {{ __('updated') }} {{ $entryInfo['updated_at'] ?? '' }}<br/>
                    {{ __('hash') }} {{ $entryInfo['hash'] ?? '' }}<br/>
                </div>

                <!-- Pole 'Ticker' -->
                <div>
                    <x-input-label for="ticker" :value="__('Ticker')"/>
                    <x-text-input wire:model="ticker"
                                  id="ticker"
                                  name="ticker"
                                  type="text"
                                  class="mt-1 block w-full" required autocomplete="ticker"/>
                    <x-input-error class="mt-2" :messages="$errors->get('ticker')"/>
                </div>

                <!-- Select 'Stock Market' -->
                <div class="col-span-2">
                    <x-input-label for="stock_markets_id" :value="__('Stock Market')"/>
                    <select wire:model="stock_markets_id" id="stock_markets_id" name="stock_markets_id"
                            class="mt-1 w-full">
                        <option value="">{{ __('Select Stock Market') }}</option>
                        @foreach($stockMarkets as $stockMarket)
                            <option
                                value="{{ $stockMarket->id }}" {{ $stockMarket->id == $stock_markets_id ? 'selected' : '' }}>
                                {{ $stockMarket->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('stock_markets_id')"/>
                </div>

                <!-- Pole 'URL' -->
                <div class="col-span-3">
                    <x-input-label for="url" :value="__('URL')"/>
                    <x-text-input wire:model="url"
                                  id="url"
                                  name="url"
                                  type="text"
                                  class="mt-1 block w-full" required autocomplete="url"/>
                    <x-input-error class="mt-2" :messages="$errors->get('url')"/>
                </div>

                <!-- Pole 'Notes' -->
                <div class="col-span-3">
                    <x-input-label for="notes" :value="__('Notes')"/>
                    <x-text-input wire:model="notes"
                                  id="notes"
                                  name="notes"
                                  type="text"
                                  class="mt-1 block w-full" required autocomplete="notes"/>
                    <x-input-error class="mt-2" :messages="$errors->get('notes')"/>
                </div>

            </div>

        </form>

    </div>
</div>
