<div x-data="{
    start_time: $persist($wire.entangle('start_time')),
    time_spent: $persist($wire.entangle('time_spent')),
    company: $persist($wire.entangle('company')),
    segment: $persist($wire.entangle('segment')),
    task: $persist($wire.entangle('task')),
    last_resume: $persist($wire.entangle('last_resume')),
    isPaused: $persist($wire.entangle('isPaused')),
}" class="px-4 mx-auto space-y-5 max-w-7xl sm:px-6 lg:px-8">
    <div wire:key="xcsiddweur83ur8927rjr9882qf" class="flex max-w-3xl p-2 mx-auto space-x-3 border rounded-md">
        @if ($start_time)
            @if ($isPaused)
                <div wire:key="resume-button">
                    <x-button wire:click="resumeTime" icon="play" positive outline>
                        Resume
                    </x-button>
                </div>
            @else
                <div wire:key="pause-button">
                    <x-button wire:click="pauseTime" icon="pause" blue outline>
                        Pause
                    </x-button>
                </div>
            @endif
            <div wire:key="resart-button">
                <x-button
                x-on:confirm="{
                    title: 'Are you sure you want to restart the timer?',
                    icon: 'warning',
                    method: 'restartForm',
                }"
                icon="stop" red outline>
                    Clear Form
                </x-button>
            </div>
        @else
            <x-button wire:click="startTime" icon="play" positive outline>
                Start
            </x-button>
        @endif
    </div>
    <div class="relative space-y-5">
       @if ($isPaused)
       <div wire:key="paused" class="absolute top-0 z-30 flex items-center justify-center w-full h-full bg-gray-100/30">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9v6m-4.5 0V9M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
    </div>
       @endif
        <div wire:key="ndi82io3iq3ufasfhfcy38u9303e3" x-show="start_time" x-cloak class="max-w-3xl p-5 mx-auto border border-t-4 rounded-md bg-gray-50 border-t-blue-600">
            <div class="grid gap-3">
                <x-native-select wire:model="company" label="Choose Company" >
                    <option value="">Select Company</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </x-native-select>
                <x-native-select wire:model="segment" label="Choose Segment" >
                    <option value="">Select Segment</option>
                    @foreach ($segments as $segment)
                        <option value="{{ $segment->id }}">{{ $segment->description }}</option>
                    @endforeach
                </x-native-select>
                <x-native-select wire:model="task" label="Choose Task" >
                    <option value="">Select Task</option>
                    @foreach ($tasks as $task)
                        <option value="{{ $task->id }}">{{ $task->name }}</option>
                    @endforeach
                </x-native-select>
            </div>
        </div>
        <div wire:key="324832rf28ej9f87r3fh7f8qj985" x-show="start_time" x-cloak id="questions" class="max-w-3xl p-5 mx-auto border border-t-4 rounded-md border-t-green-600 bg-gray-50">
            <div class="grid gap-3">
                @forelse ($questions as $key=>$item)
                    <div wire:key="{{ $key . $item->id }}">
                        @if ($item->selectable)
                            <x-native-select wire:key="questionsForm.{{ $item->id }}.id" wire:model.defer="questionsForm.{{ $item->id }}"
                                label="Question #{{ $key + 1 }}. {{ $item->message }}">
                                <option value="">Select Option</option>
                                @php
                                    $options = explode(',', $item->options);
                                @endphp
                                @foreach ($options as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </x-native-select>
                        @else
                            <x-input wire:key="questionsForm.{{ $item->id }}.id"  label="Question #{{ $key + 1 }}. {{ $item->message }}"
                                wire:model.defer="questionsForm.{{ $item->id }}" />
                        @endif
                    </div>
                @empty
                    <div class="text-center">
                        <p class="text-gray-500">No Questions</p>
                    </div>
                @endforelse
            </div>
        </div>
        <div wire:key="83423jf2ruiweriuywehwyr8736284682" x-show="start_time" x-cloak x-collapse class="max-w-3xl p-2 mx-auto border rounded-md">
            <x-button type="button" wire:click.prevent="handleSubmit" positive>
                Submit
            </x-button>
        </div>
    </div>
</div>
