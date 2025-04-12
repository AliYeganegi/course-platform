<?php

namespace App\Services;

use Alive2212\LaravelSmartResponse\ResponseModel;
use App\Models\Otp;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpEmail;
use Illuminate\Support\Facades\Redis;
use Alive2212\LaravelSmartResponse\SmartResponse;
use App\Course;
use App\Enrollment;
use App\Jobs\SendEmailJob;

class CourseRegisterService
{
    private $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function sendInvitationLinkToUser($email, Course $course)
    {
        $course_link = $course->course_link;


        // Send Register email
        $this->emailService->sendCourseRegisterEmail($email, $course_link);
    }

    public function sendEnrollmentRequestToAdmin(Enrollment $enrollment)
    {
        $this->emailService->sendEnrollmentRequestEmail($enrollment);
    }

    public function handleEnrollmentNotification(Enrollment $enrollment): void
    {
        // ToDo
        if ($enrollment->status === 'accepted' && $enrollment->course->course_link) {
            $this->sendInvitationLinkToUser($enrollment->user->email, $enrollment->course);
        }
        else if ($enrollment->status != 'accepted')
        {
            $this->sendEnrollmentRequestToAdmin($enrollment);
        }
    }
}
