<div class="space-y-5">
    <dl class="grid grid-cols-1 gap-5 mt-5 sm:grid-cols-3">
        <div class="px-4 py-5 overflow-hidden bg-white border rounded-lg hover:shadow sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">
                Today Submissions Today
            </dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                {{ $data['submission_today'] }}
            </dd>
        </div>

        <div class="px-4 py-5 overflow-hidden bg-white border rounded-lg hover:shadow sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">
                Total Submissions This Month
            </dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                {{ $data['submission_this_month'] }}
            </dd>
        </div>
        <div class="px-4 py-5 overflow-hidden bg-white border rounded-lg hover:shadow sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">
                Total Submissions
            </dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                {{ $data['submission_all_time'] }}
            </dd>
        </div>
    </dl>
    <div class="grid h-[200px] gap-5 sm:grid-cols-12">
        <div class="p-5 border rounded-lg sm:col-span-6">
            <div class="flex mb-2">
                <span>
                    Total Submission per Company
                </span>
            </div>
            <canvas  id="perCompanyChart" height="100"/>
            </canvas>
        </div>
        <div class="p-5 border rounded-lg sm:col-span-6">
            <div class="flex mb-2">
                <span>
                   Submission for the last 7 days
                </span>
            </div>
            <canvas id="perDay" >
            </canvas>
        </div>
    </div>
</div>

@push('scripts')
    <script src=" https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js "></script>
    <script type="module">
    const companies = @json($companiesInArray);
    const names = companies.map(company => company.name);
    const totalSubmissions = @json($submissionCountPerCompanyInArray);
    const totalsLookup = {};
    totalSubmissions.forEach(t => {
        totalsLookup[t.company_id] = t.total;
    });
    const totalArr = companies.map(c => totalsLookup[c.id]);
    new Chart(document.getElementById('perCompanyChart'), {
            type: 'pie',
            data: {
                labels: names,
                datasets: [{
                    label: 'Submissions',
                    data: totalArr,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1
                }]
            },
        });

    const lastSevenDaysLabels = @json($lastSevenDaysLabels);
    const lastSevenDaysValues = @json($lastSevenDaysValues);

    new Chart(document.getElementById('perDay'), {
            type: 'line',
            data: {
                labels: lastSevenDaysLabels,
                datasets: [{
                    label: 'Submissions',
                    data: lastSevenDaysValues,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }]
            },
        });
</script>
@endpush
