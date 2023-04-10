<div class="grid space-y-4">
    <div class="flex items-center p-2 space-x-2 border rounded-lg">
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
    <div class="flex justify-end">
        <x-button wire:click="print"  icon="printer" green spinner="spinner" >
            Print
        </x-button>
    </div>
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
                    <x-t-cell>{{ $submission->agent_name }}</x-t-cell>
                    <x-t-cell>
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
                    </x-t-cell>
                    <x-t-cell>{{ $submission->record_number }}</x-t-cell>
                    <x-t-cell>{{ $submission->company->name }}</x-t-cell>
                    <x-t-cell>{{ $submission->segment->description }}</x-t-cell>
                    <x-t-cell>{{ $submission->task->name }}</x-t-cell>
                    <x-t-cell>
                        <x-button wire:click="showQuestionsModal({{ $submission->id }})" sm type="button" warning>
                            View
                        </x-button>
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
    <div>
        <x-modal.card title="Answers"  wire:model.defer="showQuestions">
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
</div>

