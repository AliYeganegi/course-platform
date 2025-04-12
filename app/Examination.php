<?php

namespace App;

use App\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_link',
        'quiz_status',
        'quiz_start_datetime',
        'quiz_end_datetime',
        'quiz_number_of_attempts',
        'course_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
