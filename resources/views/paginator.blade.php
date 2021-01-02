    @if ($paginator->hasPages())
        <div class="flex items-center justify-between px-4 py-3 bg-white sm:px-6">
            <div class="hidden sm:block">
                <p class="text-sm leading-5 text-gray-700">
                    Showing
                    <span><span class="font-medium">{{ $paginator->firstItem() }}</span> to <span class="font-medium">{{ $paginator->lastItem() }}</span> of</span> <span class="font-medium">{{ $paginator->total() }}</span> results
                </p>
            </div>
            <div class="flex justify-between flex-1 sm:justify-end">
                @if ($paginator->onFirstPage())
                    <span disabled="disabled" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium leading-5 text-gray-300 bg-white border border-gray-200 rounded-md cursor-default">
                        @lang('pagination.previous')
                    </span>
                @else
                    <button wire:click="previousPage" href="{{ $paginator->previousPageUrl() }}" class="items-center justify-center px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md focus:outline-none hover:bg-blue-500 focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700">
                        @lang('pagination.previous')
                    </button>
                @endif
                @if ($paginator->hasMorePages())
                    <button wire:click="nextPage" class="items-center justify-center px-4 py-2 ml-3 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md focus:outline-none hover:bg-blue-500 focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700">
                        {!! __('pagination.next') !!}
                    </button>
                @else
                    <span disabled="disabled"class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium leading-5 text-gray-300 bg-white border border-gray-200 rounded-md cursor-default">
                        @lang('pagination.next')
                    </span>
                @endif
            </div>
        </div>
    @endif
