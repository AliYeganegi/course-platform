<?php

namespace App\Services;

use App\Course;
use App\User;

class EnrollmentService
{
    public function isUserEnrolled(User $user, Course $course): bool
    {
        return $course->enrollments()->where('user_id', $user->id)->exists();
    }

    public function enrollUser(User $user, Course $course)
    {
        $enrollment = $course->enrollments()->create([
            'user_id' => $user->id,
        ]);

        if (is_null($course->price) || $course->price == 0) {
            $enrollment->status = 'accepted';
            $enrollment->save();
        }

        return $enrollment;
    }
}
