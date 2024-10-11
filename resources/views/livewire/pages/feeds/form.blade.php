<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('News feeds') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Create new news feed') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Add url to feed or xml") }}
                    </p>
                </header>

                <form wire:submit.prevent="save" class="mt-6 space-y-6">
                    <div>
                        <x-input-label for="title" :value="__('Title')"/>
                        <x-text-input wire:model="title"
                                      id="title"
                                      name="title"
                                      type="text"
                                      class="mt-1 block w-full"
                                      required
                                      autofocus
                                      autocomplete="title"/>
                        <x-input-error class="mt-2" :messages="$errors->get('title')"/>
                    </div>

                    <div>
                        <x-input-label for="content" :value="__('Feed url')"/>
                        <textarea wire:model="feed_url"
                                  id="feed_url"
                                  name="feed_url"
                                  type="text"
                                  class="mt-1 block w-full"
                                  required></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('feed_url')"/>
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
