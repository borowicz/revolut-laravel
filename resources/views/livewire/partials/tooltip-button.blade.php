<div class="relative" x-data="{ showTooltip: false }">
    <button class="px-4 py-2 bg-gray-500 text-white rounded"
            @mouseenter="showTooltip = true"
            @mouseleave="showTooltip = false">{{ $ttTxt }}</button>
    <div class="absolute left-0 mt-2 w-40 p-2 bg-gray-500 text-white text-sm rounded shadow-lg"
         style="display: none;"
         x-show="showTooltip">{{ $ttComment }}</div>
</div>
