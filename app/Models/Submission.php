<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATUSES = [
        'pending' => 'Pending',
        'in_progress' => 'In Progress',
        'paused' => 'Paused',
        'submitted' => 'Submitted'
    ];

    const PENDING = 'pending';
    const IN_PROGRESS = 'in_progress';
    const PAUSED = 'paused';
    const SUBMITTED = 'submitted';

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function submissionAnswers()
    {
        return $this->hasMany(SubmissionAnswer::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function segment()
    {
        return $this->belongsTo(Segment::class);
    }

    public function timelines()
    {
        return $this->hasMany(Timeline::class);
    }

    public function isPending()
    {
        return $this->status === self::PENDING;
    }

    public function isInProgress()
    {
        return $this->status === self::IN_PROGRESS;
    }

    public function isPaused()
    {
        return $this->status === self::PAUSED;
    }

    public function isSubmitted()
    {
        return $this->status === self::SUBMITTED;
    }


    public function getStatus()
    {
        return self::STATUSES[$this->status];
    }

    public function tempAnswer()
    {
        return $this->hasOne(TempAnswer::class);
    }
}
