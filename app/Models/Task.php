<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function segment()
    {
        return $this->belongsTo(Segment::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function tempAnswer()
    {
        return $this->hasOne(TempAnswer::class);
    }
}
