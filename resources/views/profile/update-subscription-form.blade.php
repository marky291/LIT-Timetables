<x-jet-form-section submit="updateSubscriptionInformation">
    <x-slot name="title">
        {{ __('Subscriptions') }}
    </x-slot>

    <x-slot name="description">
        {{ __("We will notify you with timetable changes by email.") }}
    </x-slot>

    <x-slot name="form">

        @if (!$this->hasSubscriptions())
            <div class="col-span-6">
                <h3 class="text-lg font-medium text-gray-900">
                    You have no subscriptions
                </h3>
                <p class="mt-3 max-w-xl text-sm text-gray-600">
                    To get notifications when a timetable changes, you must first search the timetable and then hit the subscribe button
                </p>
            </div>
        @endif

        @if ($this->notifiableCourses->count() > 0)
            <div class="mt-4 sm:mt-0 sm:col-span-6">
                <div class="max-w-lg space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Courses</h3>
                    @foreach($this->notifiableCourses as $subscription)
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input wire:model="state.{{ $subscription->getKey() }}" value="{{ $subscription->getKey() }}" id="comments" name="comments" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <p class="font-medium text-gray-700">{{ $subscription->notifiable->name }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($this->notifiableLecturers->count() > 0)
            <div class="mt-4 sm:mt-0 sm:col-span-6">
                <div class="max-w-lg space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Lecturers</h3>
                    @foreach($this->notifiableLecturers as $subscription)
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input checked wire:model="state.{{ $subscription->getKey() }}" value="{{ $subscription->getKey() }}" id="comments" name="comments" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <p class="font-medium text-gray-700">{{ $subscription->notifiable->fullname }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="true" wire:target="state">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>

</x-jet-form-section>
