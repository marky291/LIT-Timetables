<div class="p-3 m-20 bg-white rounded-lg shadow-md">

    <div wire:loading>
        Processing Payment...
    </div>

    <div wire:loading.remove>
        <div class="flex items-end mb-2">
            <div class="w-12 h-12 p-2 mr-6 text-white rounded shadow bg-white-500">
                <img src="{{ $icon }}" alt="Current weather">
            </div>
            <h3 class="text-gray-500">{{ $city }}</h3>
        </div>
        <div class="flex mb-2">
            <div class="mr-12">
                {{ $temp }}
            </div>
            <div class="">
                0%
            </div>
        </div>
        <div class="text-gray-500">
            {{ $weather }}
        </div>
    </div>
</div>
