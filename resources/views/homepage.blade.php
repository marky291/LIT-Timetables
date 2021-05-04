<x-app-layout>

    <main class="lg:relative">
        <div class="w-full pt-16 pb-20 mx-auto text-center max-w-7xl lg:py-48 lg:text-left">
            <div class="px-4 lg:w-1/2 sm:px-8 xl:pr-16">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-6xl lg:text-5xl xl:text-6xl">
                    <span class="block xl:inline dark:text-gray-300">Smarter approach to</span>
                    <span class="block text-indigo-600 xl:inline">web timetables</span>
                </h1>
                <p class="max-w-md mx-auto mt-3 text-lg text-gray-500 sm:text-xl md:mt-5 md:max-w-3xl">
                    Built for mobile and crammed with smart features to make your day less stressful.
                </p>
                <div class="mt-10 sm:flex sm:justify-center lg:justify-start">
                    <div x-data class="rounded-md shadow">
                        <button dusk="button-search" @click="$dispatch('search')" href="#" class="flex items-center justify-center w-full px-8 py-3 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg> Start Search
                        </button>
                    </div>
                    <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                        <a dusk="href-learnmore" target="_blank" href="https://github.com/marky291/lit-timetables" class="flex items-center justify-center w-full px-8 py-3 text-base font-medium text-indigo-600 bg-white border border-transparent rounded-md hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                            Open Source
                        </a>
                    </div>
                </div>

                <div class="pt-12 text-gray-500">
                    {{ \Illuminate\Foundation\Inspiring::quote() }}
                </div>
            </div>
        </div>
        <div class="relative w-full h-64 sm:h-72 md:h-96 lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 lg:h-full">
            <img class="absolute inset-0 object-cover w-full h-full" src="https://images.unsplash.com/photo-1520333789090-1afc82db536a?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=2102&amp;q=80" alt="">
        </div>
    </main>

</x-app-layout>
