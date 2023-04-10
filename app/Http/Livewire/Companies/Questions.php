<?php

namespace App\Http\Livewire\Companies;

use Livewire\Component;

class Questions extends Component
{
    protected $listeners = ['viewTask' => 'showQuestions'];

    public $taskId = null;

    public $show = false;

    public function showQuestions($taskId)
    {
        $this->taskId = $taskId;
        $this->show = true;
    }

    public function removeTask()
    {
        $this->taskId = null;
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.companies.questions');
    }
}
