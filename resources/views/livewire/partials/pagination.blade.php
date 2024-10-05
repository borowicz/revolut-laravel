
{{--@if ($hasPages ?? false)--}}
{{--@if ($items->hasPages() && $hasPages)--}}

@if ($hasPages)
    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $items->onEachSide(1)->links() }}
    </div>
@endif
