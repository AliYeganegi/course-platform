<?php

namespace App\Services;

use App\Mail\CourseRegister;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpEmail;

class EmailService
{
    public function sendCourseRegisterEmail($email, $courseLink)
    {
        Mail::to($email)->send(new CourseRegister($email, $courseLink));
    }
}
