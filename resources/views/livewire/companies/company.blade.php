<div x-data>
    <main class="flex-1">
        <div class="py-8 xl:py-5">
            <div class="px-4 mx-auto sm:px-6 lg:px-8 xl:grid xl:grid-cols-3">
                <aside class="hidden xl:block xl:pr-8">
                    <h2 class="text-lg font-bold text-gray-700">Segments</h2>
                    <ul class="mt-5 space-y-3" x-animate>
                        @forelse ($segments as $segment)
                            <li wire:key="segment{{ $segment->id }}"
                                wire:click="$set('selectedSegmentId',{{ $segment->id }})"
                                wire:loading.class="cursor-progress"
                                class="flex items-center p-2 border rounded-md cursor-pointer hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" @class([
                                        'h-6',
                                        'w-0 duration-150' => $selectedSegmentId !== $segment->id,
                                        'w-6 duration-150' => $selectedSegmentId === $segment->id,
                                    ])>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                </svg>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $segment->description }}
                                </span>
                            </li>
                        @empty
                            <li class="p-2 rounded-md ">
                                <span class="text-sm font-medium text-gray-900">
                                    No segments found
                                </span>
                            </li>
                        @endforelse
                    </ul>
                    <div class="py-3 mt-6 space-y-8 border-t border-gray-200">
                        <div class="z-10 grid w-full gap-3">
                            <x-textarea wire:model.defer="addSegmentForm.description" placeholder="Add new segment"
                                class="w-full" />
                            <x-button wire:click="addSegment" spinner="addSegment" primary>Add</x-button>
                        </div>
                    </div>
                </aside>
                <div class="xl:col-span-2 xl:border-l xl:border-gray-200 xl:pl-8">
                    <div class="bg-white ">
                        <div x-data="{ addTask: false }">
                            <div class="mx-auto divide-y  divide-gray-900/10">
                                <div class="flex items-center justify-between mb-3">
                                    <h2 class="text-2xl font-bold leading-10 tracking-tight text-gray-900">
                                        Tasks
                                    </h2>
                                    @if ($selectedSegmentId)
                                        <x-button x-on:click="addTask=!addTask" primary flat icon="plus">Add New Task
                                        </x-button>
                                    @endif
                                </div>
                                <div class="pt-3">
                                    @if ($selectedSegmentId)
                                        <div wire:key="task-list" class="flow-root">
                                            <div x-cloak x-show="addTask" x-collapse class="w-full"
                                                x-on:click.away="addTask=false">
                                                <div class="grid w-full mb-2 space-y-3">
                                                    <x-textarea wire:model.defer="addTaskForm.name" type="text"
                                                        placeholder="Add New tasks" class="w-full" />
                                                    <x-button type="button" wire:click="addTask" spinner="addTask"
                                                        primary>Add</x-button>
                                                </div>
                                            </div>
                                            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                                    <div class="overflow-hidden ">
                                                        <div class="min-w-full">
                                                            <div class="grid gap-3 bg-white" x-animate>
                                                                @forelse ($tasks as $task)
                                                                    <div x-data="{ show: false }"
                                                                        wire:key="{{ $task->id }}-task-item"
                                                                        class="py-3 border rounded-md item-center">
                                                                        <div class="flex justify-between">
                                                                            <div
                                                                                class="pl-4 pr-3 text-sm font-medium text-gray-900 underline whitespace-nowrap">
                                                                                {{ $task->name }}
                                                                            </div>
                                                                            <div
                                                                                class="relative flex items-center pl-3 pr-4 space-x-2 text-sm font-medium text-right whitespace-nowrap ">
                                                                                <button x-on:click="show=!show">
                                                                                    <svg x-bind:class="{
                                                                                        'rotate-180 duration-150': show,
                                                                                        'rotate-0 duration-150':
                                                                                            !show
                                                                                    }"
                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                        fill="none"
                                                                                        viewBox="0 0 24 24"
                                                                                        stroke-width="1.5"
                                                                                        stroke="currentColor"
                                                                                        class="w-6 h-6">
                                                                                        <path stroke-linecap="round"
                                                                                            stroke-linejoin="round"
                                                                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                                                    </svg>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <div x-show="show" x-collapse.duration.500>
                                                                            <div
                                                                                class="flex items-center justify-between px-4 py-2">
                                                                                <h1 class="text-gray-600">
                                                                                    Questions
                                                                                </h1>
                                                                                <x-button
                                                                                    wire:click="showCreateQuestionModal({{ $task->id }})"
                                                                                    flat primary xs label="New Question"
                                                                                    icon="plus" />
                                                                            </div>
                                                                            <div class="">
                                                                                <ul >
                                                                                    @forelse ($task->questions as $key=>$question)
                                                                                        <li x-data="{showSelection:false}" wire:key="question-{{ $question->id }}" class="px-3">
                                                                                           {{ $key + 1 }}. {{ $question->message }} <button wire:click="showEditQuestionModal({{ $question->id }})" class="text-sm text-yellow-600 underline">Edit</button>
                                                                                           @if ($question->selectable) 
                                                                                           <button x-on:click="showSelection=!showSelection"> 
                                                                                            <svg x-bind:class="{
                                                                                                'rotate-180 duration-150': showSelection,
                                                                                                'rotate-0 duration-150':
                                                                                                    !showSelection
                                                                                            }"
                                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                                fill="none"
                                                                                                viewBox="0 0 24 24"
                                                                                                stroke-width="1.5"
                                                                                                stroke="currentColor"
                                                                                                class="w-3 h-3 mt-2">
                                                                                                <path stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                                                            </svg>
                                                                                        </button>
                                                                                           @endif
                                                                                           @if ($question->selectable)
                                                                                            @php
                                                                                                $options = explode(',', $question->options);
                                                                                            @endphp
                                                                                            <div
                                                                                                x-show="showSelection"
                                                                                                x-collapse.duration.500
                                                                                            >
                                                                                                <ul class="px-5">
                                                                                                    @foreach ($options as $option)
                                                                                                       <li wire:key="sq-{{ $key.$question->id }}-selection">-  {{ $option }}</li>
                                                                                                    @endforeach
                                                                                                </ul>
                                                                                            </div>
                                                                                           @endif
                                                                                        </li>
                                                                                    @empty
                                                                                        <li>
                                                                                            No questions found
                                                                                        </li>
                                                                                    @endforelse
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="2"
                                                                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                                            <div class="text-center">
                                                                                No tasks found
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div wire:key="empty-task"
                                            class="flex items-center justify-center w-full pt-10">
                                            <h1 class="text-xl font-semibold text-gray-600">
                                                Select a segment to view tasks
                                            </h1>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div wire:key="create-question-modal">
        <x-modal wire:model.defer="createQuestionModal">
            <x-card title="Create Question">
                <div class="grid gap-3">
                    <x-textarea label="Question" wire:model.defer="createQuestionForm.question"
                        placeholder="Question" />
                    <x-input label="Selecteble Options"
                        corner-hint="Seperate options with comma (,) e.g. option1,option2,option3"
                        wire:model.defer="createQuestionForm.options" placeholder="Options"
                        hint="Optional | Leave it blank if not applicable" />
                </div>
                <x-slot name="footer">
                    <div class="flex justify-end gap-x-4">
                        <x-button flat label="Cancel" x-on:click="close" />
                        <x-button wire:click.prevet="createQuestion" spinner="createQuestion" positive
                            label="Save" />
                    </div>
                </x-slot>
            </x-card>
        </x-modal>
    </div>

    <div wire:key="edit-question-modal">
        <x-modal wire:model.defer="editQuestionModal">
            <x-card title="Update Question">
                <div class="grid gap-3">
                    <x-textarea label="Question" wire:model.defer="updateQuestionForm.question"
                        placeholder="Question" />
                    <x-input label="Selecteble Options"
                        corner-hint="Seperate options with comma (,) e.g. option1,option2,option3"
                        wire:model.defer="updateQuestionForm.options" placeholder="Options"
                        hint="Optional | Leave it blank if not applicable" />
                </div>
                <x-slot name="footer">
                    <div class="flex justify-end gap-x-4">
                        <x-button flat label="Cancel" x-on:click="close" />
                        <x-button wire:click.prevet="updateQuestion" spinner="updateQuestion" positive
                            label="Update" />
                    </div>
                </x-slot>
            </x-card>
        </x-modal>
    </div>
</div>
