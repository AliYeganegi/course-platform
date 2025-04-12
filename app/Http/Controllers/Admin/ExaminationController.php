<?php

namespace App\Http\Controllers\Admin;

use App\Examination;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExaminationRequest;
use App\Http\Requests\UpdateExaminationRequest;
use App\Services\ExaminationService;
use Illuminate\Http\Request;

class ExaminationController extends Controller
{
    public function __construct(
        private ExaminationService $examinationService
    )
    {}

    public function store(StoreExaminationRequest $request)
    {
        $examination = Examination::create($request->all());

        $this->examinationService->sendQuizNotificationToUsers($examination);

        return redirect()->route('admin.courses.edit', $request->course_id)
            ->with('message', trans('cruds.examination.quiz_added'));
    }

    public function update(UpdateExaminationRequest $request, Examination $examination)
    {
        $examination->update($request->all());

        return redirect()->back()->with('message', trans('cruds.examination.quiz_updated'));
    }


    public function destroy(Examination $examination)
    {
        $courseId = $examination->course_id;
        $examination->delete();

        return redirect()->route('admin.courses.edit', $courseId)
            ->with('message', trans('cruds.examination.quiz_deleted'));
    }
}
