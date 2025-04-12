<?php

namespace App\Http\Controllers\Admin;

use App\Examination;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExaminationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'quiz_link' => 'required|url',
            'quiz_status' => 'required|in:active,inactive',
            'quiz_start_datetime' => 'nullable|date',
            'quiz_end_datetime' => 'nullable|date',
            'quiz_number_of_attempts' => 'required|integer|min:1',
        ]);

        $examination = new Examination();
        $examination->course_id = $request->course_id;
        $examination->quiz_link = $request->quiz_link;
        $examination->quiz_status = $request->quiz_status;
        $examination->quiz_start_datetime = $request->quiz_start_datetime;
        $examination->quiz_end_datetime = $request->quiz_end_datetime;
        $examination->quiz_number_of_attempts = $request->quiz_number_of_attempts;
        $examination->save();

        return redirect()->route('admin.courses.edit', $request->course_id)
            ->with('message', trans('cruds.examination.quiz_added'));
    }

    public function update(Request $request, Examination $examination)
    {
        $request->validate([
            'quiz_link' => 'required|url',
            'quiz_status' => 'required|in:active,inactive',
            'quiz_start_datetime' => 'nullable|date',
            'quiz_end_datetime' => 'nullable|date|after_or_equal:quiz_start_datetime',
            'quiz_number_of_attempts' => 'required|integer|min:1',
        ]);

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
