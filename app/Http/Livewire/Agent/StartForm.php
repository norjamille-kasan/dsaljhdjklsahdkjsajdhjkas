<?php

namespace App\Http\Livewire\Agent;

use App\Models\Company;
use App\Models\Question;
use App\Models\Segment;
use App\Models\Submission;
use App\Models\Task;
use App\Services\QuestionService;
use Carbon\Carbon;
use Livewire\Component;
use WireUi\Traits\Actions;

class StartForm extends Component
{
    use Actions;

    public $formId;

    public $submission;

    public $agent_name;

    public $start_time;

    public $end_time;

    public $record_number;

    public $time_spent;

    public $pauses_and_resumes = [];

    public $company;

    public $segment;

    public $task;

    public $questionsForm = [];

    public $companies = [];

    public $segments = [];

    public $tasks = [];

    public $questions = [];

    public $last_resume;

    public $isPaused = false;

    public function validateForm()
    {
        $this->validate([
            'company' => 'required',
            'segment' => 'required',
            'task' => 'required',
        ], [], [
            'record_number' => 'Record Number',
            'company' => 'Company',
            'segment' => 'Segment',
            'task' => 'Task',
        ]);
    }

    public function mount($formId = null)
    {
        $this->companies = Company::all();

        if ($this->formId) {
            $this->submission = Submission::find($this->formId);
            $this->agent_name = $this->submission->agent_name;
            $this->start_time = $this->submission->start_time;
            $this->end_time = $this->submission->end_time;
            $this->record_number = $this->submission->record_number;
            $this->time_spent = $this->submission->time_spent;
            $this->pauses_and_resumes = $this->submission->pauses_and_resumes;
            $this->company = $this->submission->company_id;
            $this->segment = $this->submission->segment_id;
            $this->task = $this->submission->task_id;
        }
    }

    public function updatedCompany()
    {
        $this->segments = Segment::where('company_id', $this->company)->get();
    }

    public function updatedSegment()
    {
        $this->tasks = Task::where('segment_id', $this->segment)->get();
    }

    public function updatedTask()
    {
        $this->questions = Question::where('task_id', $this->task)->get();
    }

    public function restartForm()
    {
        $this->agent_name = null;
        $this->start_time = null;
        $this->end_time = null;
        $this->record_number = null;
        $this->time_spent = null;
        $this->pauses_and_resumes = [];
        $this->company = null;
        $this->segment = null;
        $this->task = null;
        $this->questionsForm = [];
        $this->companies = [];
        $this->segments = [];
        $this->tasks = [];
        $this->questions = [];
        $this->last_resume = null;
        $this->isPaused = false;
    }

    public function render()
    {
        return view('livewire.agent.start-form');
    }

    public function startTime()
    {
        $this->start_time = Carbon::now()->format('Y-m-d H:i:s');
    }

    public function pauseTime()
    {
        if ($this->last_resume) {
            $time_spent = Carbon::parse($this->last_resume)->diffInSeconds(Carbon::now());
            $this->time_spent += $time_spent;
        } else {
            $this->time_spent = Carbon::parse($this->start_time)->diffInSeconds(Carbon::now());
        }
        $this->isPaused = true;
    }

    public function resumeTime()
    {
        $this->last_resume = Carbon::now()->format('Y-m-d H:i:s');
        $this->isPaused = false;
    }

    public function endTime()
    {
        $this->end_time = Carbon::now()->format('Y-m-d H:i:s');
    }

    public function handleSubmit()
    {
        $this->end_time = Carbon::now()->format('Y-m-d H:i:s');
        $this->pauseTime();
        $this->validateForm();

        $questionCount = count($this->questions);

        $answersCount = count($this->questionsForm);

        foreach ($this->questions as $question) {
            $keys = array_keys($this->questionsForm);
            if (! in_array($question->id, $keys)) {
                $this->addError('questionsForm.'.$question->id, 'This question is required');
            } else {
                if (empty($this->questionsForm[$question->id])) {
                    $this->addError('questionsForm.'.$question->id, 'This question is required');
                }
            }
        }

        (new QuestionService)->saveAnswer(
            $this->start_time,
            $this->time_spent,
            $this->company,
            $this->segment,
            $this->task,
            $this->questionsForm,
        );

        $this->restartForm();

        $this->notification()->success(
            $title = 'Success',
            $description = 'Form submitted successfully'
        );
    }
}
