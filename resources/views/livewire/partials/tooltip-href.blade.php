<span class="relative" x-data="{ showTooltip: false }">
    <a href="{{ $url }}" class="px-4 py-2"
          @mouseenter="showTooltip = true"
          @mouseleave="showTooltip = false">{{ $urlTxt }}</a>
    <span class="absolute left-0 mt-5 p-4 bg-gray-500 text-white text-sm rounded min-w-[200px] max-w-[400px]"
          style="display: none;"
          x-show="showTooltip">{{ $urlCmt }}</span>
</span>
