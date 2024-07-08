<div class="flex items-center">
    <span class="mr-2">{{ $columnName }}</span>
    @if ($sortColumn !== $columnName)
        <x-heroicon-s-chevron-up-down class="w-6 h-6 flex-shrink-0" />
    @elseif($sortDirection === 'ASC')
        <x-heroicon-s-chevron-down class="w-6 h-6 flex-shrink-0" />
    @else
        <x-heroicon-s-chevron-up class="w-6 h-6 flex-shrink-0" />
    @endif
</div>
