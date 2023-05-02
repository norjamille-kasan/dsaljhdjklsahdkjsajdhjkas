<?php

namespace App\Http\Livewire\Companies;

use App\Models\Question;
use App\Models\Segment;
use App\Models\Task;
use App\Services\CompanyService;
use App\Services\QuestionService;
use Livewire\Component;
use WireUi\Traits\Actions;

class Company extends Component
{
    use Actions;

    public $company;

    public $createQuestionModal = false;

    public $editQuestionModal = false;

    public $createQuestionForm = [
        'task_id' => '',
        'question' => '',
        'options' => '',
    ];

    public $updateQuestionForm = [
        'task_id' => '',
        'question' => '',
        'options' => '',
        'id' => '',
    ];

    public $addSegmentForm = [
        'description' => '',
    ];

    public $addTaskForm = [
        'name' => '',
    ];

    public $selectedSegmentId = null;

    public function validateAddTaskForm()
    {
        $this->validate([
            'addTaskForm.name' => 'required',
        ], [], [
            'addTaskForm.name' => 'Task Name',
        ]);
    }

    public function validateAddSegmentForm()
    {
        $this->validate([
            'addSegmentForm.description' => 'required',
        ], [], [
            'addSegmentForm.description' => 'Segment Description',
        ]);
    }

    public function validateCreateQuestionForm()
    {
        $this->validate([
            'createQuestionForm.question' => 'required',
            'createQuestionForm.options' => 'nullable',
        ], [], [
            'createQuestionForm.question' => 'Question',
            'createQuestionForm.options' => 'Options',
        ]);
    }

    public function validateUpdateQuestionForm()
    {
        $this->validate([
            'updateQuestionForm.question' => 'required',
            'updateQuestionForm.options' => 'nullable',
        ], [], [
            'updateQuestionForm.question' => 'Question',
            'updateQuestionForm.options' => 'Options',
        ]);
    }

    public function render()
    {
        return view('livewire.companies.company', [
            'segments' => Segment::whereCompanyId($this->company->id)->get(),
            'tasks' => $this->selectedSegmentId ? Task::query()
                                ->whereSegmentId($this->selectedSegmentId)
                                ->orderBy('position', 'asc')
                                ->with('questions')
                                ->get()
                                : [],
        ]);
    }

    public function addSegment()
    {
        $this->validateAddSegmentForm();

        (new CompanyService)->addSegement($this->addSegmentForm['description'], $this->company->id);

        $this->addSegmentForm['description'] = '';
    }

    public function addTask()
    {
        $this->validateAddTaskForm();

        (new CompanyService)->addTask($this->selectedSegmentId, $this->addTaskForm['name']);

        $this->addTaskForm['name'] = '';
    }

    public function showCreateQuestionModal($taskId)
    {
        $this->createQuestionForm['task_id'] = $taskId;
        $this->createQuestionModal = true;
    }

    public function createQuestion()
    {
        $this->validateCreateQuestionForm();

        (new QuestionService)->createQuestion(
            $this->createQuestionForm['question'],
            $this->createQuestionForm['options'],
            $this->createQuestionForm['task_id']
        );

        $this->createQuestionForm['question'] = '';
        $this->createQuestionForm['options'] = '';
        $this->createQuestionModal = false;

        $this->notification()->success(
            $title = 'Success',
            $description = 'You have successfully created a question.'

        );
    }

    public function showEditQuestionModal($questionId)
    {
        $question = Question::find($questionId);

        $this->updateQuestionForm['id'] = $question->id;
        $this->updateQuestionForm['question'] = $question->message;
        $this->updateQuestionForm['options'] = $question->options;
        $this->updateQuestionForm['task_id'] = $question->task_id;

        $this->editQuestionModal = true;
    }

    public function updateQuestion()
    {
        $this->validateUpdateQuestionForm();
        (new QuestionService)->updateQuestion(
            $this->updateQuestionForm['id'],
            $this->updateQuestionForm['question'],
            $this->updateQuestionForm['options'],
            $this->updateQuestionForm['task_id']
        );

        $this->updateQuestionForm['question'] = '';
        $this->updateQuestionForm['options'] = '';
        $this->updateQuestionForm['id'] = '';
        $this->updateQuestionForm['task_id'] = '';
        $this->editQuestionModal = false;

        $this->notification()->success(
            $title = 'Success',
            $description = 'You have successfully updated a question.'
        );
    }

    public function deleteTask($taskId)
    {
        $task = Task::find($taskId);

        $task->delete();
        
        $this->notification()->success(
            $title = 'Success',
            $description = 'You have successfully deleted a task.'
        );
    }
}
