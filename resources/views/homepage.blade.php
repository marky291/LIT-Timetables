<x-app-layout>

    <main class="lg:relative">
        <div class="absolute w-full h-full" id="particles-js">

        </div>
        <div class="w-full py-48 mx-auto text-center max-w-7xl">
            <div class="px-4 sm:px-8">
                <div>
                    <h1 class="block text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-6xl xl:inline dark:text-dark-text">{{ __('Smarter approach to') }}</h1>
                </div>
                <div>
                    <h1 class="block text-4xl font-extrabold tracking-tight text-gray-900 text-indigo-600 sm:text-5xl md:text-6xl xl:inline">{{ __('LIT Timetables') }}</h1>
                </div>
                <p class="max-w-md mx-auto mt-3 text-lg text-gray-500 dark:text-dark-text sm:text-xl md:mt-5 md:max-w-3xl">
                    {{ __('Built for mobile and crammed with smart features to make your day less stressful.') }}
                </p>
                <div class="mt-10 sm:flex sm:justify-center">
                    <div x-data class="rounded-md shadow">
                        <button dusk="button-search" @click="$dispatch('search')" href="#" class="flex items-center justify-center w-full px-8 py-3 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            {{ __('Start Search') }}
                        </button>
                    </div>
                    <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                        <a dusk="href-learnmore" target="_blank" href="https://github.com/marky291/lit-timetables" class="flex items-center justify-center w-full h-full px-8 py-3 text-base font-medium text-indigo-600 bg-white rounded-md dark:button hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6 mr-2">
                                <path d="M12 2C6.477 2 2 6.463 2 11.97c0 4.404 2.865 8.14 6.839 9.458.5.092.682-.216.682-.48 0-.236-.008-.864-.013-1.695-2.782.602-3.369-1.337-3.369-1.337-.454-1.151-1.11-1.458-1.11-1.458-.908-.618.069-.606.069-.606 1.003.07 1.531 1.027 1.531 1.027.892 1.524 2.341 1.084 2.91.828.092-.643.35-1.083.636-1.332-2.22-.251-4.555-1.107-4.555-4.927 0-1.088.39-1.979 1.029-2.675-.103-.252-.446-1.266.098-2.638 0 0 .84-.268 2.75 1.022A9.606 9.606 0 0112 6.82c.85.004 1.705.114 2.504.336 1.909-1.29 2.747-1.022 2.747-1.022.546 1.372.202 2.386.1 2.638.64.696 1.028 1.587 1.028 2.675 0 3.83-2.339 4.673-4.566 4.92.359.307.678.915.678 1.846 0 1.332-.012 2.407-.012 2.734 0 .267.18.577.688.48C19.137 20.107 22 16.373 22 11.969 22 6.463 17.522 2 12 2z"></path>
                            </svg> {{ __('Open Source') }}
                        </a>
                    </div>
                </div>

                <div class="pt-12 text-gray-500 dark:text-dark-text">
                    {{ \Illuminate\Foundation\Inspiring::quote() }}
                </div>
            </div>
        </div>
    </main>

    @livewire('statistics')

    @include('features')

    @include('about')

</x-app-layout>
