<div class="grid space-y-4">
    <div class="flex justify-between p-2 space-x-2 border rounded-lg">
        {{-- action panel --}}
        <div class="flex space-x-2 tems-center">
            <x-native-select wire:model="filterCompany">
                <option value="">All Companies</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </x-native-select>
            <x-native-select wire:model="filterSegment">
                <option value="">All Segments</option>
                @foreach ($segments as $segment)
                    <option value="{{ $segment->id }}">{{ $segment->description }}</option>
                @endforeach
            </x-native-select>
            <x-native-select wire:model="filterTask">
                <option value="">All Tasks</option>
                @foreach ($tasks as $task)
                    <option value="{{ $task->id }}">{{ $task->name }}</option>
                @endforeach
            </x-native-select>
            <span class="text-gray-300">
                |
            </span>
            <div class="flex items-center space-x-2">
                <span>
                    Start Date
                </span>
                <x-input type="date" wire:model="filterStartDate" class="pl-4" />
            </div>
            <div class="flex items-center space-x-2">
                <span>
                    End Date
                </span>
                <x-input type="date" wire:model="filterEndDate" class="pl-4" />
            </div>
            <x-button wire:click="clearDateFilter" red spinner="clearDateFilter">
                Clear Date
            </x-button>
        </div>
        <div class="flex space-x-2">
            <x-button wire:click="startNewForm" icon="plus" spinner="startNewForm" primary green>
                New Form
            </x-button>
            <x-button wire:click="print" icon="printer" green spinner="spinner">
                Print
            </x-button>
        </div>
    </div>
    {{-- data table --}}
    {{-- <div>
        <x-table :headers="[
            'Application ID',
            'Agent Name',
            'Start Time - End Time (Time Spent)',
            'Record Number',
            'Company',
            'Segment',
            'Task',
            '',
        ]">
            @forelse ($submissions as $submission)
                <tr>
                    <x-t-cell>{{ $submission->id }}</x-t-cell>
                    <x-t-cell>{{ $submission->agent_name??'N/A' }}</x-t-cell>
                    <x-t-cell>
                        @if ($submission->start_time)
                        {{ \Carbon\Carbon::parse($submission->start_time)->format('d/m/Y h:i A') }}
                        -
                        {{ \Carbon\Carbon::parse($submission->end_time)->format('d/m/Y h:i A') }}
                        @php
                            $mins = $submission->total_time_spent / 60;
                            $hours = $mins / 60;
                            $mins = $mins % 60;
                            $hours = $hours % 60;
                            $time_spent = $hours . 'h ' . $mins . 'm';
                        @endphp
                        ({{ $time_spent }})
                        @else
                            N/A
                        @endif
                    </x-t-cell>
                    <x-t-cell>{{ $submission?->record_number??'N/A' }}</x-t-cell>
                    <x-t-cell>{{ $submission?->company->name??'N/A' }}</x-t-cell>
                    <x-t-cell>{{ $submission?->segment->description??'N/A' }}</x-t-cell>
                    <x-t-cell>{{ $submission?->task->name??'N/A' }}</x-t-cell>
                    <x-t-cell>
                       <div class="flex space-x-2">
                        @if ($submission->status == 'pending')
                            <x-button href="{{ route('agent.start-form',['id'=>$submission->id]) }}" sm type="button" flat color="blue">
                                Start Form
                            </x-button>
                        @endif
                        @if ($submission->status == 'paused')
                            <x-button href="{{ route('agent.start-form',['id'=>$submission->id]) }}" sm type="button" flat warning>
                                Continue
                            </x-button>
                        @endif
                        @if ($submission->status == 'submitted')
                            <x-button sm type="button" flat positive>
                                View
                            </x-button>
                        @endif
                        @if ($submission->isInProgress())
                            <x-button  href="{{ route('agent.start-form',['id'=>$submission->id]) }}" sm type="button" flat positive>
                                Continue <span class="text-red-600 animate-pulse">(In Progress)</span>
                            </x-button>
                        @endif
                       </div>
                    </x-t-cell>
                </tr>
            @empty
                <tr>
                    <x-t-cell colspan="8" class="text-center">No Submissions</x-t-cell>
                </tr>
            @endforelse
            <x-slot name="footer">
                {{ $submissions->links() }}
            </x-slot>
        </x-table>
    </div> --}}

    <div>
        <div class="overflow-hidden bg-white border sm:rounded-md">
            <ul role="list" class="divide-y divide-gray-200">
                @forelse ($submissions as $submission)
                    <li x-data="{ expanded: false }" x-on:click.away="expanded=false">
                        <a href="#" class="block hover:bg-gray-50">
                            <div class="flex items-center py-4 ">
                                <div class="flex items-center flex-1 min-w-0">
                                    <div class="flex-1 min-w-0 px-4 md:grid md:grid-cols-2 md:gap-4">
                                        <div>
                                            @if ($submission->isSubmitted())
                                                <p class="text-sm font-medium text-indigo-600 truncate">
                                                    {{ $submission->agent_name }} {{ $submission->pause_id ? '| Pause ID :'.$submission->pause_id : '' }}
                                                </p>
                                            @else
                                                <p class="text-sm font-medium text-red-600 truncate animate-pulse">
                                                    Pending ....
                                                </p>
                                            @endif
                                            <p class="flex items-center mt-2 text-sm text-gray-500">
                                                <span class="mr-1">#</span>
                                                <span class="truncate">{{ $submission->record_number }}</span>
                                            </p>
                                        </div>
                                        <div class="hidden md:block">
                                            <div>
                                                <p class="text-sm text-gray-900">
                                                    Created At
                                                    <time datetime="2020-01-07">
                                                        {{ $submission->created_at->format('M d, Y h:i A') }}
                                                    </time>
                                                </p>
                                                <p class="flex items-center mt-2 text-sm text-gray-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6 mr-1">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    {{ \Carbon\Carbon::parse($submission->start_time)->format('d/m/Y h:i A') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($submission->end_time)->format('d/m/Y h:i A') }}
                                                    @php
                                                        $mins = $submission->total_time_spent / 60;
                                                        $hours = $mins / 60;
                                                        $mins = $mins % 60;
                                                        $hours = $hours % 60;
                                                        $time_spent = $hours . 'h ' . $mins . 'm';
                                                    @endphp
                                                    ({{ $time_spent }})
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button x-on:click="expanded=!expanded" class="pr-5">
                                    <svg x-bind:class="{
                                        'rotate-90 duration-150': expanded,
                                        'rotate-0  duration-150': !expanded
                                    }"
                                        class="text-gray-400 w-7 h-7" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </a>
                        <div x-cloak x-show="expanded" x-collapse x-data="{ hov: false }">
                            <div class="flex justify-end p-2 mb-2 space-x-2 border-y">
                                @if ($submission->isPending())
                                    <x-button href="{{ route('agent.start-form', ['id' => $submission->id]) }}"
                                        icon="document-duplicate" label="Start Form" flat sm />
                                @endif
                                @if ($submission->isSubmitted())
                                    {{-- <x-button icon="eye" label="View" flat sm /> --}}
                                    <x-badge positive>
                                        Submitted
                                    </x-badge>
                                @endif
                                @if ($submission->isInProgress())
                                    <x-button href="{{ route('agent.start-form', ['id' => $submission->id]) }}" icon="pencil" flat sm>
                                        <span class="text-red-500 animate-pulse">
                                            Continue
                                        </span>
                                    </x-button>
                                @endif
                                @if ($submission->isPaused())
                                    <x-button  href="{{ route('agent.start-form', ['id' => $submission->id]) }}" icon="play" label="Resume" flat sm />
                                @endif
                            </div>
                            <div x-on:dblclick="hov=true"
                                class="p-2 m-2 bg-gray-100 border border-indigo-600 rounded-lg">
                                <div>
                                    <div class="flow-root ">
                                        <ul role="list" class="-my-5 divide-y divide-gray-200">
                                            @forelse ($submission->submissionAnswers as $key => $answer)
                                                <li class="py-5">
                                                    <div
                                                        class="relative focus-within:ring-2 focus-within:ring-indigo-500">
                                                        <h3 class="text-sm font-semibold text-gray-800">
                                                            <a href="#"
                                                                class="hover:underline focus:outline-none">
                                                                <!-- Extend touch target to entire panel -->
                                                                <span class="absolute inset-0"
                                                                    aria-hidden="true"></span>
                                                                Question #{{ $key + 1 }} :
                                                                {{ $answer->question->message }} @if ($answer->question->selectable)
                                                                    | Choice : {{ $answer->question->options }}
                                                                @endif
                                                            </a>
                                                        </h3>
                                                        <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                                            Answer : {{ $answer->answer }}
                                                        </p>
                                                    </div>
                                                </li>
                                            @empty
                                                <li class="py-5">
                                                    <div
                                                        class="relative focus-within:ring-2 focus-within:ring-indigo-500">
                                                        <h3 class="text-sm font-semibold text-gray-800">
                                                            <a href="#"
                                                                class="hover:underline focus:outline-none">
                                                                <!-- Extend touch target to entire panel -->
                                                                <span class="absolute inset-0"
                                                                    aria-hidden="true"></span>
                                                                No answers found
                                                            </a>
                                                        </h3>
                                                    </div>
                                                </li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li>
                        <div class="flex items-center justify-center py-5">
                            <span class="text-center text-gray-500">
                                No submissions found
                            </span>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>
        <div class="mt-2">
            {{ $submissions->links() }}
        </div>
    </div>

    {{-- loading indicator --}}
    <div wire:loading.flex wire:target="startNewForm"
        class="absolute right-0 z-50 flex items-center justify-center w-full h-full -top-4 bg-gray-400/50">
        <div class="space-y-3">
            <div class="typewriter">
                <div class="slide"><i></i></div>
                <div class="paper"></div>
                <div class="keyboard"></div>
            </div>
            <h1 class="text-2xl font-extrabold text-indigo-700">
                Please wait...
            </h1>
        </div>
    </div>
</div>
