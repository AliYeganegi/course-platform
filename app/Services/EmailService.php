<?php

namespace App\Services;

use App\Course;
use App\Enrollment;
use App\Examination;
use App\Mail\CourseRegister;
use App\Mail\EnrollmentRequest;
use App\Mail\ExaminationCreate;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpEmail;
use App\User;

class EmailService
{
    public function sendCourseRegisterEmail($email, $courseLink)
    {
        Mail::to($email)->send(new CourseRegister($email, $courseLink));
    }

    public function sendEnrollmentRequestEmail(Enrollment $enrollment)
    {
        if ($enrollment->course->instructor->email) {
            Mail::to($enrollment->course->instructor->email)->send(new EnrollmentRequest($enrollment));
        }
    }

    public function sendQuizCreationEmail(Examination $examination)
    {
        foreach ($examination->course->enrollments as $enrollment) {
            $registeredUser = $enrollment->user;
            if ($registeredUser) {
                Mail::to($registeredUser->email)->send(new ExaminationCreate($examination));
            }
        }
    }
}
