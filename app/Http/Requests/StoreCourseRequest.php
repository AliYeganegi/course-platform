<?php

namespace App\Http\Requests;

use App\Course;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class StoreCourseRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('course_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'name'           => [
                'required',
                'unique:courses',
            ],
            'institution_id' => [
                'required',
                'integer',
            ],
            'disciplines.*'  => [
                'integer',
            ],
            'disciplines'    => [
                'array',
            ],
            'course_file'    => 'nullable|file|max:2048000',
        ];
    }
}
