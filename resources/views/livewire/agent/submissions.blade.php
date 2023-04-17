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
    <div>
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
                        @if ($submission->status=='pending')
                            <x-button href="{{ route('agent.start-form',['id'=>$submission->id]) }}" sm type="button" flat color="blue">
                                Start Form
                            </x-button>
                        @endif
                        @if ($submission->status=='paused')
                            <x-button href="{{ route('agent.start-form',['id'=>$submission->id]) }}" sm type="button" flat warning>
                                Continue
                            </x-button>
                        @endif
                        @if ($submission->status=='submitted')
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
    </div>

    {{-- modal --}}
    <div>
        <x-modal.card title="Answers" wire:model.defer="showQuestions">
            @if ($showQuestions)
                <ul class="space-y-3">
                    @foreach ($answers as $answer)
                        <li class="grid">
                            <div class="font-bold">Q :{{ $answer->question->message }}</div>
                            <div class="text-gray-500">
                                A : ({{ $answer->answer }})
                            </div>
                        </li>
                    @endforeach
                </ul>

            @endif
        </x-modal.card>
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
