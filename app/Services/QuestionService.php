<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Submission;
use Illuminate\Support\Facades\DB;

class QuestionService
{
    public function createQuestion(
    $question,
    $selectableOption,
    $taskId
  ) {
        $getLatesPosition = Question::whereTaskId($taskId)->count();
        $newPosition = $getLatesPosition + 1;
        $question = Question::create([
            'message' => $question,
            'selectable' => $selectableOption ? true : false,
            'options' => $selectableOption,
            'task_id' => $taskId,
            'position' => $newPosition,
        ]);

        return $question;
    }

    public function updateQuestion(
    $questionId,
    $message,
    $selectableOption,
    $taskId,
  ) {
        $question = Question::find($questionId);
        $question->update([
            'message' => $message,
            'selectable' => $selectableOption ? true : false,
            'options' => $selectableOption,
            'task_id' => $taskId,
        ]);

        return $question;
    }

    public function saveAnswer(
    $submission,
    $company,
    $segment,
    $task,
    $questionsForm = []
  ) {
        $submitionCount = Submission::where('status','submitted')->count();
        $initials = substr(auth()->user()->name, 0, 1);
        DB::beginTransaction();
        $submission->update([
            'user_id' => auth()->user()->id,
            'agent_name' => auth()->user()->name,
            'pauses_and_resumes' => 'N/A',
            'end_time' => now(),
            'record_number' => now()->format('Ymd') . '-' . $initials . '-' . str_pad($submitionCount +1, 11, '0', STR_PAD_LEFT),
            'company_id' => $company,
            'segment_id' => $segment,
            'task_id' => $task,
            'status' => Submission::SUBMITTED,
        ]);

        DB::table('submission_answers')->insert(
            $this->prepareAnswers($questionsForm, $submission->id)
        );

        DB::commit();

        return $submission;
    }

    public function prepareAnswers($questionsForm, $submissionId)
    {
        $answers = [];
        foreach ($questionsForm as $questionId => $answer) {
            $answers[] = [
                'submission_id' => $submissionId,
                'question_id' => $questionId,
                'answer' => $answer,
            ];
        }

        return $answers;
    }
}
