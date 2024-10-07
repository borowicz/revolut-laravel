@if (session()->has('message'))
    <div class="px-4 sm:px-6 lg:px-8 alert alert-success">
        {{ session('message') }}
    </div>
@endif

@error('file')
<div class="px-4 sm:px-6 lg:px-8 alert alert-error">
    <span class="error">{{ $message }}</span>
</div>
@enderror

<br class="clearfix"/>

<div class="px-4 sm:px-6 lg:px-8">
    <form wire:submit.prevent="uploadCsv"
          enctype="multipart/form-data"
          class="flex items-center w-full flex space-x-4">
        <div class="flex-1">
            <label for="file-upload" class="sr-only">Choose file</label>
            <input type="file"
                   {{ $isUploaded ? 'disabled="disabled"' : '' }}
                   id="file-upload"
                   name="file"
                   wire:model="file"
                   class="block w-full border border-gray-200
    shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500
    disabled:opacity-50 disabled:pointer-events-none
    dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400
    file:bg-gray-50 file:border-0
    file:me-4
    file:py-3 file:px-4
    dark:file:bg-neutral-700 dark:file:text-neutral-400"
            />

        </div>
        <div class="flex-none">
            <button type="submit"
                    {{ $isUploaded ? 'disabled="disabled"' : '' }}
                    wire:loading.attr="disabled"
                    class="inline-flex items-center px-4 py-2 bg-gray-800
   border border-transparent rounded-md
   font-semibold text-xs text-white
   uppercase tracking-widest
   hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900
   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
   transition ease-in-out duration-150"
            >
                {{ __('Import...') }}
            </button>
        </div>

        @if($isUploaded)
            <button type="button" wire:click="resetUpload">{{ __('Upload Another File') }}</button>
        @endif
    </form>

    @if ($file ?? false)

        {{ __('filename:') }}&nbsp;
        {{ $file->getClientOriginalName() }}
        <br/>
        {{ __('size:') }}&nbsp;
        {{ $file->getSize() }}
        <br/>
        {{ __('uploded file:') }}&nbsp;
        {{ $file->getRealPath() }},
    @endif

    <div wire:loading wire:target="file">
        {{ __('Uploading...') }}
        <hr/>
    </div>


</div>
<br class="clearfix"/>
