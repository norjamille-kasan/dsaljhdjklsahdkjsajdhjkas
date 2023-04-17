<?php

namespace App\Http\Livewire\Agent;

use Livewire\Component;
use App\Models\Submission;
use App\Models\Company;
use App\Models\Question;
use App\Models\Segment;
use App\Models\Task;
use App\Models\Timeline;
use Carbon\Carbon;
use WireUi\Traits\Actions;
use WireUi\View\Components\Card;
use App\Services\QuestionService;


class TaskForm extends Component
{
    use Actions;
    public $submissionId;

    public $submission;
    public $answers;

    public $companies = [];
    public $segments = [];
    public $tasks = [];
    public $questions = [];

    // form attributes
    public $companyId;
    public $segmentId;
    public $taskId;

    // temp answers
    public $tempAnswers = [];

    public $questionsForm = [];

    public function mount($submissionId)
    {
        abort_if(!$submissionId, 404);
        $this->submissionId = $submissionId;
        $this->submission = Submission::findOrFail($submissionId);

        $this->loadUnfinishedSubmission($this->submission);

        $this->companies = Company::all();

        // load segments if company is selected
        $this->segments = $this->companyId ? Segment::where('company_id', $this->companyId)->get() : [];
        // load tasks if segment is selected
        $this->tasks = $this->segmentId ? Task::where('segment_id', $this->segmentId)->get() : [];
        // load questions if task is selected
        $this->questions = $this->taskId ? Question::whereTaskId($this->taskId)->get() : [];

        // load temp answers if task is selected | node :  can be empty
        $this->tempAnswers =$this->taskId ?  $this->submission->tempAnswer : [];

        if ($this->tempAnswers) {
            $tempAnswers = json_decode($this->tempAnswers->question_answers);
            $this->questionsForm = collect($tempAnswers)->mapWithKeys(function ($item) {
                return [$item->question_id => $item->answer];
            })->toArray();
        }
    }

    public function updatedCompanyId()
    {
        $this->segments = Segment::where('company_id', $this->companyId)->get();
        $this->submission->update([
            'company_id' => $this->companyId
        ]);
    }

    public function updatedSegmentId()
    {
        $this->tasks = Task::where('segment_id', $this->segmentId)->get();

        $this->submission->update([
            'segment_id' => $this->segmentId
        ]);
    }

    public function updatedTaskId()
    {
        $this->questions = Question::whereTaskId($this->taskId)->get();

        $this->submission->update([
            'task_id' => $this->taskId
        ]);

        // questions that are already answered by the agent should be loaded

        // if there is no temp answers, create new temp answers
        if(!$this->tempAnswers){
            $this->tempAnswers = $this->submission->tempAnswer()->create([
                'task_id' => $this->taskId,
                'question_answers' => $this->questions->map(function($question){
                    return [
                        'question_id' => $question->id,
                        'answer' => null
                    ];
                })
            ]);
        }else{
            // if there are temp answers, update the temp answers
            $this->tempAnswers->update([
                'task_id' => $this->taskId,
                'question_answers' => $this->questions->map(function($question){
                    return [
                        'question_id' => $question->id,
                        'answer' => null
                    ];
                })
            ]);
        }
    }

    public function render()
    {
        return view('livewire.agent.task-form',[
            'timelines'=>Timeline::where('submission_id', $this->submission->id)->latest()->get()
        ]);
    }

    public function handleSave()
    {
        $this->validateForms();

      

        (new QuestionService)->saveAnswer(
            $this->submission,
            $this->companyId,
            $this->segmentId,
            $this->taskId,
            $this->questionsForm,
        );

        $this->submission->timelines()->create([
            'description' => 'Paused',
            'date_and_time'=> Carbon::now()
        ]);

        $this->notification()->success(
            $title = 'Success',
            $description = 'Form submitted successfully'
        );

        return redirect()->route('agent.submissions');
    }


    // ------------------ Actions ------------------ //
    public function clickStart()
    {
        $this->submission->update([
            'start_time' => Carbon::now(),
            'status' => Submission::IN_PROGRESS
        ]);
    }

    public function clickPause()
    {
        $this->submission->update([
            'status' => Submission::PAUSED
        ]);

        $this->submission->timelines()->create([
            'description' => 'Paused',
            'date_and_time'=> Carbon::now()
        ]);

        // update the temp answers with the current answers from questionsForm
        if ($this->questionsForm) {
            $new_question_answers = [];

            foreach ($this->questionsForm as $questionId => $answer) {
                $new_question_answers[] = [
                    'question_id' => $questionId,
                    'answer' => $answer
                ];
            }
    
            $this->tempAnswers->update([
                'question_answers' => $new_question_answers
            ]);
        }
    }

    public function clickResume()
    {
        $lastAction = Timeline::where('submission_id', $this->submission->id)
                        ->latest()
                        ->first();
        if($lastAction->description === "Paused"){
            $pausedDuration = Carbon::now()->diffInSeconds($lastAction->date_and_time);

            $createNewTimeline = Timeline::create([
                'submission_id' => $this->submission->id,
                'description' => 'Resumed',
                'date_and_time'=> Carbon::now(),
                'time_before_resume'=>$pausedDuration,
            ]);

            $this->submission->update([
                'status' => Submission::IN_PROGRESS
            ]);
        }
    }

    // ------------------ Helpers ------------------ //
    // if form already started, load the data
    function loadUnfinishedSubmission($submission)
    {
        $this->companyId = $submission->company_id;
        $this->segmentId = $submission->segment_id;
        $this->taskId = $submission->task_id;
    }

    function validateForms()
    {
        $this->validate([
            'companyId' => 'required',
            'segmentId' => 'required',
            'taskId' => 'required',
        ]);

        foreach ($this->questions as $question) {
            $keys = array_keys($this->questionsForm);
            if (!in_array($question->id, $keys)) {
                $this->addError('questionsForm.' . $question->id, 'This question is required');
            } else {
                if (empty($this->questionsForm[$question->id])) {
                    $this->addError('questionsForm.' . $question->id, 'This question is required');
                }
            }
        }
    }
}
