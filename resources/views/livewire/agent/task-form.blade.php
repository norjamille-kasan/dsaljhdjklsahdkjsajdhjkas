<div x-data class="relative space-y-5" x-animate>
    <div class="flex items-center w-full p-2 mx-auto space-x-3 border rounded-md max-w-7xl">
        @if ($submission->status === 'pending')
            <x-button wire:click="clickStart" primary icon="play" label="Start" />
        @endif
        @if ($submission->status === 'in_progress')
            <x-button wire:click="clickPause" warning icon="pause" label="Pause" />
        @endif
        @if ($submission->status === 'paused')
            <x-button wire:click="clickResume" positive icon="play" label="Resume" />
        @endif
    </div>
    <div wire:key="ndi82io3iq3ufasfhfcy38u9303e3"
        class="grid grid-cols-6 gap-4 p-5 mx-auto border border-t-4 rounded-md max-w-7xl bg-gray-50 border-t-blue-600">
        <div class="gap-3 sm:col-span-4">
            <div class="space-y-4">
                <x-native-select :disabled="$submission->isPaused() || !$submission->isInProgress()" wire:model="companyId" label="Choose Company">
                    <option value="">Select Company</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </x-native-select>
                <x-native-select :disabled="$submission->isPaused() || !$submission->isInProgress()" wire:model="segmentId" label="Choose Segment">
                    <option value="">Select Segment</option>
                    @foreach ($segments as $segment)
                        <option value="{{ $segment->id }}">{{ $segment->description }}</option>
                    @endforeach
                </x-native-select>
                <x-native-select :disabled="$submission->isPaused() || !$submission->isInProgress()" wire:model="taskId" label="Choose Task">
                    <option value="">Select Task</option>
                    @foreach ($tasks as $task)
                        <option value="{{ $task->id }}">{{ $task->name }}</option>
                    @endforeach
                </x-native-select>
            </div>
            @if ($taskId)
                <div wire:key="324832rf28ej9f87r3fh7f8qj985"
                    class="w-full p-5 mt-5 border border-green-600 rounded-md bg-gray-50">
                    <div class="grid gap-3">
                        @forelse ($questions as $key=>$item)
                            <div wire:key="{{ $key . $item->id }}">
                                @if ($item->selectable)
                                    <x-native-select :disabled="$submission->isPaused()" wire:key="questionsForm.{{ $item->id }}.id"
                                        wire:model.defer="questionsForm.{{ $item->id }}"
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
                                    <x-input :disabled="$submission->isPaused()" wire:key="questionsForm.{{ $item->id }}.id"
                                        label="Question #{{ $key + 1 }}. {{ $item->message }}"
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
                <div class="flex mt-2 space-x-2">
                   @if ($submission->isInProgress())
                    <x-button positive wire:click="handleSave" spinner="handleSave" label="Save" />
                   @endif
                </div>
            @endif
        </div>
        <div class="col-span-2 space-y-3 ">
            <h1>
                Timeline
            </h1>
            <ul role="list" class="mt-6 space-y-6 h-[500px] overflow-auto pr-5" animate>
               @foreach ($timelines as $activity)
               <li wire:key="activity-{{ $activity->id }}" class="relative flex gap-x-4">
               @if (!$loop->last)
               <div class="absolute top-0 left-0 flex justify-center w-6 -bottom-6">
                <div class="w-px bg-gray-200"></div>
            </div>
               @endif

                <div class="relative flex items-center justify-center flex-none w-6 h-6 bg-gray-50">
                    <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>
                </div>
                <p class="flex-auto py-0.5 text-xs leading-5 text-gray-500"><span
                        class="font-medium {{ $activity->description =='Paused' ? 'text-yellow-500' : 'text-green-600' }}">
               {{ $activity->description  }}    
                </span>
                at {{ \Carbon\Carbon::parse($activity->date_and_time)->format('M d, Y h:i A') }}
            </p>
                <time datetime="2023-01-23T10:32" class="flex-none py-0.5 text-xs leading-5 text-gray-500">
                    {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                </time>
            </li>
               @endforeach
            </ul>
        </div>
    </div>
</div>
