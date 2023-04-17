<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Question;
use App\Models\Submission;
use App\Models\SubmissionAnswer;
use COM;
use Illuminate\Support\Facades\DB;

class QuestionService
{
  public function createQuestion(
    $question,
    $selectableOption = null,
    $taskId
  ) {
    $getLatesPosition = Question::whereTaskId($taskId)->count();
    $newPosition = $getLatesPosition + 1;
    $question = Question::create([
      'message' => $question,
      'selectable' => $selectableOption ? true : false,
      'options' =>  $selectableOption,
      'task_id' => $taskId,
      'position' => $newPosition,
    ]);

    return $question;
  }

  public function updateQuestion(
    $questionId,
    $message,
    $selectableOption = null,
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
    $submitionCount = Submission::count();
    $initials = substr(auth()->user()->name, 0, 1);
    DB::beginTransaction();
    $submission->update([
      'user_id' => auth()->user()->id,
      'agent_name' => auth()->user()->name,
      'pauses_and_resumes'=>'N/A',
      'end_time' => now(),
      'record_number' => date('Ymd') . '-' . $initials . '-' . ($submitionCount + 1),
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
