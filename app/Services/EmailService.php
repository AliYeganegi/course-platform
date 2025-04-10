<?php

namespace App\Services;

use App\Course;
use App\Enrollment;
use App\Mail\CourseRegister;
use App\Mail\EnrollmentRequest;
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
        Mail::to($enrollment->course->instructor->email)->send(new EnrollmentRequest($enrollment));
    }
}
