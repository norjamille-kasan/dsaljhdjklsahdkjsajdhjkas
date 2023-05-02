<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
      TCT REPORT{{ date('Y-m-d h:i A') }}
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 10px 0;
        }

        table th,
        table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #ddd;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="grid mb-5 space-y-2">
        <h1 class="text-2xl font-bold">TCT REPORT</h1>
    </div>
    <table>
        <thead>
            <tr>
                <th>
                    Agent Name
                </th>
                <th>
                    Start Time - End Time (Duration)
                </th>
                <th>
                    Record Number
                </th>
                <th>
                    Pause ID
                </th>
                <th>
                    Company Name
                </th>
                <th>
                    Segment
                </th>
                <th>
                    Task
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($submissions as $submission)
                <tr>
                    <td>
                        {{ $submission->agent_name }}
                    </td>
                    <td>
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
                    </td>
                    <td>{{ $submission->record_number }}</td>
                    <td>{{ $submission->pause_id }}</td>
                    <td>{{ $submission->company->name }}</td>
                    <td>{{ $submission->segment->description }}</td>
                    <td>{{ $submission->task->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        window.print();
    </script>
</body>

</html>
