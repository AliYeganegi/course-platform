<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Spatie\FlareClient\View;

use App\Course;
use App\Mail\CourseRegister;
use App\Services\CourseRegisterService;
use App\Services\EmailService;
use App\Services\EnrollmentService;
use App\Services\UserRegistrationService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EnrollmentController extends Controller
{

    public function __construct(
        private CourseRegisterService $courseRegisterService,
        private UserRegistrationService $userRegistrationService,
        private EnrollmentService $enrollmentService
    ) {}
    public function create(Course $course)
    {
        $breadcrumb = "Enroll in $course->name course";

        return view('enrollment.enroll', compact('course', 'breadcrumb'));
    }

    public function store(Request $request, Course $course)
    {
        if (auth()->guest()) {
            $user = $this->userRegistrationService->registerAndLogin($request);
        } else {
            $user = auth()->user();
        }

        if ($this->enrollmentService->isUserEnrolled($user, $course)) {
            return redirect()->route('enroll.myCourses')->with('message', 'You are already enrolled in this course!');
        }

        $enrollment = $this->enrollmentService->enrollUser($user, $course);

        $this->courseRegisterService->handleEnrollmentNotification($enrollment);

        return redirect()->route('enroll.myCourses');
    }

    public function handleLogin(Course $course)
    {
        return redirect()->route('enroll.create', $course->id);
    }

    public function myCourses()
    {
        $breadcrumb = "My Courses";

        $userEnrollments = auth()->user()
            ->enrollments()
            ->with('course.institution')
            ->orderBy('id', 'desc')
            ->paginate(6);

        return view('enrollment.courses', compact(['breadcrumb', 'userEnrollments']));
    }
}
