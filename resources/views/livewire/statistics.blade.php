<div class="pt-12 sm:pt-16">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-extrabold dark:text-dark-text text-gray-900 sm:text-4xl">
                Blazing Fast Searchable Results
            </h2>
            <p class="mt-3 text-xl text-gray-500 sm:mt-4">
                Data is served from our servers utilizing caching mechanisms for lightning speed.
            </p>
        </div>
    </div>
    <div class="pb-12 mt-10 sm:pb-16">
        <div class="relative">
            <div class="absolute inset-0 h-1/2"></div>
            <div class="relative px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto">
                    <dl class="rounded-lg shadow-lg sm:grid sm:grid-cols-3 border dark:border-dark-border dark:bg-dark-panel">
                        <div class="flex flex-col p-6 text-center border-b border-gray-100 sm:border-0 sm:border-r">
                            <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500">
                                Total Courses
                            </dt>
                            <dd class="order-1 text-5xl font-extrabold text-indigo-600">
                                {{ $this->courseCount }}
                            </dd>
                        </div>
                        <div class="flex flex-col p-6 text-center border-t border-b border-gray-100 sm:border-0 sm:border-l sm:border-r">
                            <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500">
                                Total Lecturers
                            </dt>
                            <dd class="order-1 text-5xl font-extrabold text-indigo-600">
                                {{ $this->lecturerCount }}
                            </dd>
                        </div>
                        <div class="flex flex-col p-6 text-center border-t border-gray-100 sm:border-0 sm:border-l">
                            <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500">
                                Total Schedules
                            </dt>
                            <dd class="order-1 text-5xl font-extrabold text-indigo-600">
                                {{ $this->scheduleCount }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
