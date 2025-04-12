<?php

namespace App\Services;

use App\Course;
use App\Enrollment;
use App\Examination;
use App\Jobs\SendEmailJob;
use App\User;

class ExaminationService
{
    public function __construct(
        private EmailService $emailService
        )
    {}

    public function sendQuizNotificationToUsers(Examination $examination)
    {
        $this->emailService->sendQuizCreationEmail($examination);
    }
}
