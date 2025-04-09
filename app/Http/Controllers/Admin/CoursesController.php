<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Discipline;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCourseRequest;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use App\User;

class CoursesController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('course_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::all();

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        abort_if(Gate::denies('course_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $institutions = Institution::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $disciplines = Discipline::all()->pluck('name', 'id');

        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('title', ['admin', 'Institution']);
        })->pluck('name', 'id');

        return view('admin.courses.create', compact('institutions', 'disciplines', 'users'));
    }

    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->all());
        $course->disciplines()->sync($request->input('disciplines', []));

        if ($request->hasFile('course_file')) {
            $file = $request->file('course_file');
            $path = $file->store('courses', 'public');
            $course->update(['course_file' => $path]);
        }

        if ($request->input('photo', false)) {
            $course->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
        }

        return redirect()->route('admin.courses.index');
    }

    public function edit(Course $course)
    {
        abort_if(Gate::denies('course_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $institutions = Institution::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $disciplines = Discipline::all()->pluck('name', 'id');

        $course->load('institution', 'disciplines');

        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('title', ['admin', 'Institution']);
        })->pluck('name', 'id');


        return view('admin.courses.edit', compact('institutions', 'disciplines', 'course', 'users'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        // Update basic course attributes
        $course->update($request->all());

        // Sync disciplines
        $course->disciplines()->sync($request->input('disciplines', []));

        // Remove course file if requested
        if ($this->removeCourseFile($request, $course)) {
            $course->save();
        }

        // Handle new course file upload
        $this->uploadCourseFile($request, $course);

        // Handle photo update
        $this->handlePhoto($request, $course);

        return redirect()->route('admin.courses.index');
    }

    private function removeCourseFile($request, $course)
    {
        if ($request->has('remove_course_file') && $request->remove_course_file == '1') {
            if ($course->course_file) {
                Storage::delete('public/' . $course->course_file);
                $course->course_file = null;
                return true;
            }
        }
        return false;
    }

    private function uploadCourseFile($request, $course)
    {
        if ($request->hasFile('course_file')) {
            if ($course->course_file) {
                Storage::disk('public')->delete($course->course_file);
            }
            $path = $request->file('course_file')->store('courses', 'public');
            $course->update(['course_file' => $path]);
        }
    }

    private function handlePhoto($request, $course)
    {
        $photoInput = $request->input('photo', false);

        if ($photoInput) {
            if (!$course->photo || $photoInput !== $course->photo->file_name) {
                if ($course->photo) {
                    $course->photo->delete();
                }
                $course->addMedia(storage_path('tmp/uploads/' . $photoInput))
                    ->toMediaCollection('photo');
            }
        } elseif ($course->photo) {
            $course->photo->delete();
        }
    }


    public function show(Course $course)
    {
        abort_if(Gate::denies('course_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course->load('institution', 'disciplines');

        return view('admin.courses.show', compact('course'));
    }

    public function destroy(Course $course)
    {
        abort_if(Gate::denies('course_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course->forceDelete();

        return back();
    }

    public function massDestroy(MassDestroyCourseRequest $request)
    {
        Course::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
