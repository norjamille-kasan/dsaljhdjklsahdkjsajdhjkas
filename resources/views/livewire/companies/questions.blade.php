<div x-data="{
    show: $wire.entangle('show'),
}">
    <div x-cloak x-show="show" class="relative z-50" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        <!-- Background backdrop, show/hide based on slide-over state. -->
        <div x-show="show" class="fixed inset-0"></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="fixed inset-y-0 right-0 flex max-w-full pl-10 pointer-events-none sm:pl-16">
                    <div x-show="show"
                        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                        class="w-screen max-w-2xl pointer-events-auto">
                        <form class="flex flex-col h-full overflow-y-scroll bg-white shadow-xl">
                            <div class="flex-1">
                                <!-- Header -->
                                <div class="px-4 py-6 bg-gray-50 sm:px-6">
                                    <div class="flex items-start justify-between space-x-3">
                                        <div class="space-y-1">
                                            <h2 class="text-base font-semibold leading-6 text-gray-900"
                                                id="slide-over-title">
                                                Questions
                                            </h2>
                                        </div>
                                        <div class="flex items-center h-7">
                                            <button wire:click="removeTask" type="button"
                                                class="text-gray-400 hover:text-gray-500">
                                                <span class="sr-only">Close panel</span>
                                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-6 space-y-6 sm:space-y-0 sm:divide-y sm:divide-gray-200 sm:py-0">
                                    <div
                                        class="px-4 space-y-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-5">
                                        <div>
                                            <label for="project-description"
                                                class="block text-sm font-medium leading-6 text-gray-900 sm:mt-1.5">
                                                Question
                                            </label>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <x-textarea rows="2"></x-textarea>
                                        </div>
                                    </div>
                                    <div
                                        class="px-4 space-y-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-5">
                                        <div>
                                            <label for="project-description"
                                                class="block text-sm font-medium leading-6 text-gray-900 sm:mt-1.5">
                                                Answer Selections
                                            </label>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <x-textarea rows="2" hint="Separate by comma e.g. Yes, No, Maybe"
                                                placeholder="e.g. Yes, No, Maybe"></x-textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 px-4 py-5 border-t border-gray-200 sm:px-6">
                                    <div class="flex justify-end space-x-3">
                                        <button type="button"
                                            class="px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancel</button>
                                        <button type="submit"
                                            class="inline-flex justify-center px-3 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
