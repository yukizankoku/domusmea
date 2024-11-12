@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex justify-between">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="disabled cursor-default bg-gray-300 text-gray-500 px-4 py-2 rounded-md">
                &laquo; Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                &laquo; Previous
            </a>
        @endif

        {{-- Pagination Elements --}}
        <div class="flex items-center space-x-1">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="disabled cursor-default bg-gray-300 text-gray-500 px-4 py-2 rounded-md">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="bg-yellow-500 text-white px-4 py-2 rounded-md">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="bg-white text-yellow-500 px-4 py-2 rounded-md hover:bg-gray-200">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Next &raquo;
            </a>
        @else
            <span class="disabled cursor-default bg-gray-300 text-gray-500 px-4 py-2 rounded-md">
                Next &raquo;
            </span>
        @endif
    </nav>
@endif
