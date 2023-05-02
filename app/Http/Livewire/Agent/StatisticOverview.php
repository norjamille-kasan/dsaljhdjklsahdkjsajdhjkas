<?php

namespace App\Http\Livewire\Agent;

use App\Models\Company;
use Livewire\Component;
use App\Models\Submission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\LivewirePieChart;

class StatisticOverview extends Component
{
    public $companiesInArray = [];
    public $submissionCountPerCompanyInArray = [];

    public $lineGraph;
    public function loadData()
    {
        $my_total_submission_today = DB::table('submissions')
            ->where('user_id', auth()->user()->id)
            ->where('status','submitted')
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->select([
                DB::raw('"submission_today" as label'),
                DB::raw('count(*) as value'),
            ]);
            
        $my_total_submission_this_month = DB::table('submissions')
            ->where('user_id', auth()->user()->id)
            ->where('status','submitted')
            ->whereMonth('created_at', '=', date('m'))
            ->select([
                DB::raw('"submission_this_month" as label'),
                DB::raw('count(*) as value'),
            ]);
        
        $my_total_submission = DB::table('submissions')
            ->where('user_id', auth()->user()->id)
            ->where('status','submitted')
            ->select([
                DB::raw('"submission_all_time" as label'),
                DB::raw('count(*) as value'),
            ]);


        return $my_total_submission_today
            ->union($my_total_submission_this_month)
            ->union($my_total_submission)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->label => $item->value];
            })->toArray();
    }

    public function mount()
    {
        $this->companiesInArray = Company::all();
        $this->submissionCountPerCompanyInArray = Submission::where('user_id', auth()->user()->id)
            ->where('status','submitted')
            ->select('company_id', DB::raw('count(*) as total'))
            ->groupBy('company_id')
            ->get();
            $startDate = now()->subDays(7)->format('Y-m-d');
            $endDate = now()->format('Y-m-d');
            
            $data = DB::table('submissions')
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('date')
                ->get();
            
                foreach (range(-6, 0) as $daysAgo) {
                    $date = now()->addDays($daysAgo)->format('Y-m-d');
                    $count = 0;
                    $found = false;
                    foreach ($data as $item) {
                        if ($item->date == $date) {
                            $count = $item->count;
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        $count = 0;
                    }
                    $this->lineGraph[$date] = $count;
                }
                
    }
    public function render()
    {
        return view('livewire.agent.statistic-overview',[
            'data' => $this->loadData(),
            'lastSevenDaysLabels' => array_keys($this->lineGraph),
            'lastSevenDaysValues' => array_values($this->lineGraph),
        ]);
    }
}
