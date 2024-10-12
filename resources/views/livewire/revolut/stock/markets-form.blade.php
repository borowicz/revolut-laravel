<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Markets') }}
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
                </header>

                <form wire:submit.prevent="save" class="mt-6 space-y-6">
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input wire:model="name"
                                      id="name"
                                      name="name"
                                      type="text"
                                      class="mt-1 block w-full" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="disabled" :value="__('Disabled')" />
                        <select wire:model="disabled" id="disabled" name="disabled" class="mt-1 block w-full" required>
                            <option value="0">{{ __('No') }}</option>
                            <option value="1">{{ __('Yes') }}</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('disabled')" />
                    </div>

                    <div>
                        <x-input-label for="country" :value="__('Country')" />
                        <x-text-input wire:model="country"
                                      id="country"
                                      name="country"
                                      type="text"
                                      class="mt-1 block w-full" required autocomplete="country" />
                        <x-input-error class="mt-2" :messages="$errors->get('country')" />
                    </div>

                    <div>
                        <x-input-label for="symbol" :value="__('Symbol')" />
                        <x-text-input wire:model="symbol"
                                      id="symbol"
                                      name="symbol"
                                      type="text"
                                      class="mt-1 block w-full" required autocomplete="symbol" />
                        <x-input-error class="mt-2" :messages="$errors->get('symbol')" />
                    </div>

                    <div>
                        <x-input-label for="suffix" :value="__('Suffix')" />
                        <x-text-input wire:model="suffix"
                                      id="suffix"
                                      name="suffix"
                                      type="text"
                                      class="mt-1 block w-full" required autocomplete="suffix" />
                        <x-input-error class="mt-2" :messages="$errors->get('suffix')" />
                    </div>

                    <div>
                        <x-input-label for="suffix_ft" :value="__('Suffix FT')" />
                        <x-text-input wire:model="suffix_ft"
                                      id="suffix_ft"
                                      name="suffix_ft"
                                      type="text"
                                      class="mt-1 block w-full" required autocomplete="suffix_ft" />
                        <x-input-error class="mt-2" :messages="$errors->get('suffix_ft')" />
                    </div>

                    <div>
                        <x-input-label for="suffix_bb" :value="__('Suffix BB')" />
                        <x-text-input wire:model="suffix_bb"
                                      id="suffix_bb"
                                      name="suffix_bb"
                                      type="text"
                                      class="mt-1 block w-full" required autocomplete="suffix_bb" />
                        <x-input-error class="mt-2" :messages="$errors->get('suffix_bb')" />
                    </div>

                    <div>
                        <x-input-label for="suffix_gf" :value="__('Suffix GF')" />
                        <x-text-input wire:model="suffix_gf"
                                      id="suffix_gf"
                                      name="suffix_gf"
                                      type="text"
                                      class="mt-1 block w-full" required autocomplete="suffix_gf" />
                        <x-input-error class="mt-2" :messages="$errors->get('suffix_gf')" />
                    </div>

                    <div>
                        <x-input-label for="currency" :value="__('Currency')" />
                        <x-text-input wire:model="currency"
                                      id="currency"
                                      name="currency"
                                      type="text"
                                      class="mt-1 block w-full" required autocomplete="currency" />
                        <x-input-error class="mt-2" :messages="$errors->get('currency')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                        <button type="button" class="inline-flex items-center px-4 py-2 rounded-md" wire:click="cancel">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
