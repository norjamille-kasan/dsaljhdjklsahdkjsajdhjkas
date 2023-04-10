<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $guarded = [];

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
}
