<span class="relative" x-data="{ showTooltip: false }">
    <span class="px-4 py-2"
          @mouseenter="showTooltip = true"
          @mouseleave="showTooltip = false">{{ $ttTxt }}</span>
    <span class="absolute left-0 mt-5 p-4 bg-gray-500 text-white text-sm rounded"
    <span class="absolute left-0 mt-5 p-4 bg-gray-500 text-white text-sm rounded"
          style="display: none;"
          x-show="showTooltip">{{ $ttComment }}</span>
</span>
