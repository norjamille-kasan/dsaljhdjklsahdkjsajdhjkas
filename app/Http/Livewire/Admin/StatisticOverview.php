<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Company;
use Livewire\Component;
use App\Models\Submission;
use Illuminate\Support\Facades\DB;

class StatisticOverview extends Component
{
    public $companiesInArray = [];

    public $submissionCountPerCompanyInArray = [];

    public $lineGraph;

    public $users;

    public function loadData()
    {
        $my_total_submission_today = DB::table('submissions')
            ->where('status', 'submitted')
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->select([
                DB::raw('"submission_today" as label'),
                DB::raw('count(*) as value'),
            ]);

        $my_total_submission_this_month = DB::table('submissions')
            ->where('status', 'submitted')
            ->whereMonth('created_at', '=', date('m'))
            ->select([
                DB::raw('"submission_this_month" as label'),
                DB::raw('count(*) as value'),
            ]);

        $my_total_submission = DB::table('submissions')
            ->where('status', 'submitted')
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
        $this->submissionCountPerCompanyInArray = Submission::query()
            ->where('status', 'submitted')
            ->select('company_id', DB::raw('count(*) as total'))
            ->groupBy('company_id')
            ->get();

        $this->users = User::all();
    }

    public function render()
    {
        $submissionsByUser = Submission::selectRaw('user_id, count(*) as count')
                    ->whereDate('created_at', '=', date('Y-m-d'))
                    ->where('status', 'submitted')
                    ->groupBy('user_id')
                    ->get()
                    ->map(function ($item) {
                        $user = $this->users->find($item->user_id);
                        $item->user_id = $user->id;
                        $item->name = $user->name;
                        return $item;
               });
        return view('livewire.admin.statistic-overview', [
            'data' => $this->loadData(),
            'submissionsByUser' => $submissionsByUser,
        ]);
    }
}
