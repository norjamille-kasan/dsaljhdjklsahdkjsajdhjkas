<?php

namespace App\Http\Livewire\Admin;

use App\Models\Company;
use App\Models\Segment;
use App\Models\Submission;
use App\Models\SubmissionAnswer;
use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;

class ManageSubmissions extends Component
{
    use WithPagination;

    public $filterCompany = '';

    public $filterSegment = '';

    public $filterTask = '';

    public $filterStartDate = '';

    public $filterEndDate = '';

    public $filterOrderBy = 'desc';

    public $showQuestions = false;

    public $queryString = [
        'filterCompany' => ['except' => '', 'as' => 'company'],
        'filterSegment' => ['except' => '', 'as' => 'segment'],
        'filterTask' => ['except' => '', 'as' => 'task'],
        'filterStartDate' => ['except' => '', 'as' => 'from_date'],
        'filterEndDate' => ['except' => '', 'as' => 'to_date'],
        'filterOrderBy' => ['except' => 'desc', 'as' => 'order_by'],
    ];

    public $companies = [];

    public $segments = [];

    public $tasks = [];

    public $answers = [];

    public function mount()
    {
        $this->companies = Company::all();

        if ($this->filterCompany != '') {
            $this->segments = Segment::where('company_id', $this->filterCompany)->get();
        }

        if ($this->filterSegment != '') {
            $this->tasks = Task::where('segment_id', $this->filterSegment)->get();
        }
    }

    public function updatedFilterCompany()
    {
        $this->segments = Segment::where('company_id', $this->filterCompany)->get();
    }

    public function updatedFilterSegment()
    {
        $this->tasks = Task::where('segment_id', $this->filterSegment)->get();
    }

    public function render()
    {
        return view('livewire.admin.manage-submissions', [
            'submissions' => Submission::query()
                ->where('status','submitted')
                ->when($this->filterCompany, function ($query) {
                    return $query->where('company_id', $this->filterCompany);
                })
                ->when($this->filterSegment, function ($query) {
                    return $query->where('segment_id', $this->filterSegment);
                })
                ->when($this->filterTask, function ($query) {
                    return $query->where('task_id', $this->filterTask);
                })
                ->when($this->filterStartDate, function ($query) {
                    return $query->where('created_at', '>=', $this->filterStartDate);
                })
                ->when($this->filterEndDate, function ($query) {
                    return $query->where('created_at', '<=', $this->filterEndDate);
                })
                ->with([
                    'task',
                    'submissionAnswers' => function ($query) {
                        $query->with('question')->orderBy('id', 'desc');
                    },
                ])
                ->orderBy('created_at', $this->filterOrderBy)
                ->paginate(10),
        ]);
    }

    public function clearDateFilter()
    {
        $this->filterStartDate = '';
        $this->filterEndDate = '';
    }

    public function showQuestionsModal($submissionId)
    {
        $this->showQuestions = true;
        $this->answers = SubmissionAnswer::where('submission_id', $submissionId)->with('question')
                        ->orderBy('id', 'desc')
                        ->get();
    }

    public function print()
    {
        return redirect('/print?filterCompany='.$this->filterCompany.'&filterSegment='.$this->filterSegment.'&filterTask='.$this->filterTask.'&filterStartDate='.$this->filterStartDate.'&filterEndDate='.$this->filterEndDate.'&filterOrderBy='.$this->filterOrderBy.'');
    }

    public function clearFilter()
    {
        $this->filterCompany = '';
        $this->filterSegment = '';
        $this->filterTask = '';
        $this->filterStartDate = '';
        $this->filterEndDate = '';
        $this->filterOrderBy = 'desc';
    }
}
